<?php

//generate rating 
function generateRatings($rating = 0) {
    $ratingtxt = ''; 
    
    
    for ($i = 1; $i <= 5; $i++) {
        $ratingtxt .= ($i <= $rating) ? 
                      '<i class="bi bi-star-fill text-warning" style="font-size: 13px;"></i>' : 
                      '<i class="bi bi-star text-secondary" style="color: #d1d5db !important; font-size: 13px;"></i>';
    }
    
    return $ratingtxt; 
}