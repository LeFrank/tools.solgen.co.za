<?php
function getEmotionIcons(){
    $directory = "927544-emotions";
    $ds = DIRECTORY_SEPARATOR;
    $tools = array(
        1 => array("name" => "Happy", "id" => 1, "colour"=>"", "icon"=>$directory.$ds."003-smile-1.svg", "category"=>"pleasurable", "triggered"=>"false"),
        2 => array("name" => "Sad", "id" => 2, "colour"=>"", "icon"=>$directory.$ds."009-sad-1.svg", "category"=>"unpleasurable","triggered"=>"true"),
        3 => array("name" => "Ambivalent", "id" => 3, "colour"=>"#0066cc", "icon"=>$directory.$ds."013-meh.svg", "category"=>"unpleasurable","triggered"=>"true"),
        4 => array("name" => "Angry", "id" => 4, "colour"=>"#0066cc", "icon"=>$directory.$ds."024-sad.svg", "category"=>"arousing","triggered"=>"true"),
        5 => array("name" => "Tired", "id" => 5, "colour"=>"#75ce66", "icon"=>$directory.$ds."001-yawn.svg", "category"=>"subduing","triggered"=>"true"),
        6 => array("name" => "Mischievous", "id" => 6, "colour"=>"#75ce66", "icon"=>$directory.$ds."002-wink.svg", "category"=>"pleasurable","triggered"=>"false"),
        7 => array("name" => "Surprised", "id" => 7, "colour"=>"", "icon"=>$directory.$ds."005-surprise.svg", "category"=>"arousing","triggered"=>"true"),
        8 => array("name" => "Shocked", "id" => 8, "colour"=>"#c03b44", "icon"=>$directory.$ds."006-shocked.svg", "category"=>"arousing","triggered"=>"true"),
        9 => array("name" => "Sceptical", "id" => 9, "colour"=>"#f0ca45", "icon"=>$directory.$ds."007-sceptic.svg", "category"=>"subduing","triggered"=>"true"),
        10 => array("name" => "Resigned", "id" => 10, "colour"=>"#75ce66", "icon"=>$directory.$ds."008-sad-2.svg", "category"=>"strained","triggered"=>"true"),
        11 => array("name" => "Relieved", "id" => 11, "colour"=>"", "icon"=>$directory.$ds."010-happy-3.svg", "category"=>"relaxation","triggered"=>"true"),
        12 => array("name" => "Hurting", "id" => 12, "colour"=>"#0066cc", "icon"=>$directory.$ds."011-pain.svg", "category"=>"arousing","triggered"=>"true"),
        13 => array("name" => "Silent", "id" => 13, "colour"=>"#0066cc", "icon"=>$directory.$ds."012-muted.svg", "category"=>"","triggered"=>""),
        14 => array("name" => "Jovial", "id" => 14, "colour"=>"#0066cc", "icon"=>$directory.$ds."014-laugh.svg", "category"=>"pleasant","triggered"=>"false"),
        15 => array("name" => "Sick", "id" => 15, "colour"=>"#0066cc", "icon"=>$directory.$ds."015-ill.svg", "category"=>"strain","triggered"=>"true"),
        16 => array("name" => "Ecstatic", "id" => 16, "colour"=>"#0066cc", "icon"=>$directory.$ds."016-happy-2.svg", "category"=>"pleasurable","triggered"=>"true"),
        17 => array("name" => "Content", "id" => 17, "colour"=>"#0066cc", "icon"=>$directory.$ds."017-happy-1.svg", "category"=>"relaxation","triggered"=>"false"),
        18 => array("name" => "Playful", "id" => 18, "colour"=>"#0066cc", "icon"=>$directory.$ds."018-cute.svg", "category"=>"pleasurable","triggered"=>"false"),
        19 => array("name" => "Distraught", "id" => 19, "colour"=>"#0066cc", "icon"=>$directory.$ds."019-crying.svg", "category"=>"strain","triggered"=>"true"),
        20 => array("name" => "Rebelious", "id" => 20, "colour"=>"#0066cc", "icon"=>$directory.$ds."020-crazy.svg", "category"=>"arousing","triggered"=>"true"),
        21 => array("name" => "Cool", "id" => 21, "colour"=>"#0066cc", "icon"=>$directory.$ds."021-cool.svg", "category"=>"relaxation","triggered"=>"true"),
        22 => array("name" => "Bored", "id" => 22, "colour"=>"#0066cc", "icon"=>$directory.$ds."022-bored.svg", "category"=>"subduing","triggered"=>"true"),
        23 => array("name" => "Embarassed", "id" => 23, "colour"=>"#0066cc", "icon"=>$directory.$ds."023-blush.svg", "category"=>"unpleasurable","triggered"=>"true"),
        24 => array("name" => "Jubilation", "id" => 24, "colour"=>"#0066cc", "icon"=>$directory.$ds."025-happy.svg", "category"=>"pleasurable","triggered"=>"true")
    );
    return $tools;
}


function getEmotionIcon($id) {
    //return array_search($id, array_column($tools, 'id'));
    return getEmotionIcons()[$id];
}

function getAllEmotionIcons(){
    return getEmotionIcons();
}
/*
 *     
 * Affection
 * Anger
 * Angst
 * Anguish
 * Annoyance
 * Anticipation
 * Anxiety
 * Apathy
 * Arousal
 * Awe
 * Boredom
 * Confidence
 * Contempt
 * Contentment
 * Courage
 * Curiosity
 * Depression
 * Desire
 * Despair
 * Disappointment
 * Disgust
 * Distrust
 * Ecstasy
 * Embarrassment
 * Empathy
 * Enthusiasm
 * Envy
 * Euphoria
 * Fear
 * Frustration
 * Gratitude
 * Grief
 * Guilt
 * Happiness
 * Hatred
 * Hope
 * Horror
 * Hostility
 * Humiliation
 * Interest
 * Jealousy
 * Joy
 * Loneliness
 * Love
 * Lust
 * Outrage
 * Panic
 * Passion
 * Pity
 * Pleasure
 * Pride
 * Rage
 * Regret
 * Rejection 
 * Remorse 
 * Resentment 
 * Sadness 
 * Saudade 
 * Schadenfreude 
 * Self-confidence 
 * Shame 
 * Shock 
 * Shyness 
 * Sorrow 
 * Suffering 
 * Surprise 
 * Trust 
 * Wonder 
 * Worry
 */