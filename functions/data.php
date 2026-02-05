<?php
/**
 * FONCTIONS DE MANIPULATION DE DONNÉES
 * Fonctions utilitaires pour formater et manipuler les données
 */

/**
 * Tronquer un texte à une longueur donnée
 * @param string $text - Texte à tronquer
 * @param int $length - Longueur maximale
 * @param string $suffix - Suffixe à ajouter (par défaut "...")
 * @return string
 */
function truncate($text, $length = 100, $suffix = '...') {
    if (strlen($text) <= $length) {
        return $text;
    }
    return substr($text, 0, $length) . $suffix;
}

/**
 * Formater une date
 * @param string $date - Date au format SQL
 * @param string $format - Format de sortie (par défaut 'd/m/Y')
 * @return string
 */
function format_date($date, $format = 'd/m/Y') {
    if (empty($date)) {
        return '';
    }
    return date($format, strtotime($date));
}

/**
 * Générer un extrait de texte HTML safe
 * @param string $text - Texte source
 * @param int $length - Longueur maximale
 * @return string
 */
function excerpt($text, $length = 150) {
    $text = strip_tags($text);
    $text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    return truncate($text, $length);
}

/**
 * Vérifier si un email est valide
 * @param string $email
 * @return bool
 */
function is_valid_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Nettoyer une chaîne pour éviter les injections
 * @param string $string
 * @return string
 */
function clean_string($string) {
    $string = trim($string);
    $string = stripslashes($string);
    $string = htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    return $string;
}

/**
 * Générer un slug à partir d'un texte
 * @param string $text
 * @return string
 */
function slugify($text) {
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    $text = trim($text, '-');
    return $text;
}

/**
 * Obtenir le temps écoulé depuis une date
 * @param string $datetime
 * @return string
 */
function time_ago($datetime) {
    $time = strtotime($datetime);
    $diff = time() - $time;
    
    if ($diff < 60) {
        return "À l'instant";
    } elseif ($diff < 3600) {
        $minutes = floor($diff / 60);
        return $minutes . " min";
    } elseif ($diff < 86400) {
        $hours = floor($diff / 3600);
        return $hours . " h";
    } elseif ($diff < 604800) {
        $days = floor($diff / 86400);
        return $days . " j";
    } else {
        return date('d/m/Y', $time);
    }
}

/**
 * Compter les mots dans un texte
 * @param string $text
 * @return int
 */
function word_count($text) {
    $text = strip_tags($text);
    return str_word_count($text);
}

/**
 * Estimer le temps de lecture en minutes
 * @param string $text
 * @return int
 */
function reading_time($text) {
    $words = word_count($text);
    $minutes = ceil($words / 200); // 200 mots par minute
    return max(1, $minutes);
}

/**
 * Convertir les URLs en liens cliquables
 * @param string $text Le texte contenant des URLs
 * @return string Le texte avec les URLs transformées en liens HTML
 */
function make_links_clickable($text) {
    // Échapper d'abord le HTML pour la sécurité
    $text = htmlspecialchars($text);
    
    // Pattern pour détecter les URLs
    $pattern = '#\b((https?|ftp)://[^\s<>]+)#i';
    
    // Remplacer les URLs par des liens cliquables
    $text = preg_replace($pattern, '<a href="$1" target="_blank" rel="noopener noreferrer" style="color: #2F509E; text-decoration: underline;">$1</a>', $text);
    
    return $text;
}

/**
 * Convertir BBCode en HTML
 * @param string $text Le texte avec BBCode
 * @return string Le texte converti en HTML
 */
function bbcode_to_html($text) {
    // Échapper le HTML d'abord pour la sécurité
    $text = htmlspecialchars($text);
    
    // Tableaux de patterns BBCode → HTML
    $patterns = [
        // Texte de base
        '/\[b\](.*?)\[\/b\]/is'                    => '<strong>$1</strong>',
        '/\[i\](.*?)\[\/i\]/is'                    => '<em>$1</em>',
        '/\[u\](.*?)\[\/u\]/is'                    => '<u>$1</u>',
        '/\[s\](.*?)\[\/s\]/is'                    => '<del>$1</del>',
        
        // Liens
        '/\[url=(.*?)\](.*?)\[\/url\]/is'          => '<a href="$1" target="_blank" rel="noopener noreferrer" style="color: #2F509E; text-decoration: underline;">$2</a>',
        '/\[url\](.*?)\[\/url\]/is'                => '<a href="$1" target="_blank" rel="noopener noreferrer" style="color: #2F509E; text-decoration: underline;">$1</a>',
        
        // Images
        '/\[img\](.*?)\[\/img\]/is'                => '<img src="$1" alt="Image" class="img-fluid rounded my-3" style="max-width: 100%;">',
        '/\[img=(.*?)\](.*?)\[\/img\]/is'          => '<img src="$2" alt="$1" class="img-fluid rounded my-3" style="max-width: 100%;">',
        
        // Couleurs
        '/\[color=(.*?)\](.*?)\[\/color\]/is'      => '<span style="color:$1">$2</span>',
        
        // Taille
        '/\[size=(.*?)\](.*?)\[\/size\]/is'        => '<span style="font-size:$1px">$2</span>',
        
        // Citations
        '/\[quote\](.*?)\[\/quote\]/is'            => '<blockquote class="border-start border-3 ps-3 my-3" style="border-color: #2F509E !important;"><em>$1</em></blockquote>',
        '/\[quote=(.*?)\](.*?)\[\/quote\]/is'      => '<blockquote class="border-start border-3 ps-3 my-3" style="border-color: #2F509E !important;"><strong>$1 a dit :</strong><br><em>$2</em></blockquote>',
        
        // Code
        '/\[code\](.*?)\[\/code\]/is'              => '<pre class="bg-light p-3 rounded"><code>$1</code></pre>',
        
        // Listes
        '/\[list\](.*?)\[\/list\]/is'              => '<ul>$1</ul>',
        '/\[\*\](.*?)\n/i'                         => '<li>$1</li>',
        
        // Centrer
        '/\[center\](.*?)\[\/center\]/is'          => '<div class="text-center">$1</div>',
    ];
    
    // Appliquer toutes les conversions
    foreach ($patterns as $pattern => $replacement) {
        $text = preg_replace($pattern, $replacement, $text);
    }
    
    // Gérer aussi les URLs normales (pour compatibilité)
    $urlPattern = '#\b((https?|ftp)://[^\s<>]+)#i';
    $text = preg_replace($urlPattern, '<a href="$1" target="_blank" rel="noopener noreferrer" style="color: #2F509E; text-decoration: underline;">$1</a>', $text);
    
    return $text;
}
?>