<?php

class collection
{
    private $word = array();
    
    public function post_chars()
    {
        if (count($this->items) < 7)
        {
            add_character($_POST['char']);
        }   
    }
    
    public function add_character($obj)
    {
        $this->word[] = $obj;
    }
    
    public function check_word($pStr)
    {
        $Dictionary = "WORD,ALPHABET,TEST,SCRABBLE,VALID";
        
        if (strpos($Dictionary,$pStr) !== false) 
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function build_word()
    {
        $str = "";
        
        foreach ($this->word as $i => $value) 
                {
                        $str .= $i;
                }
                
                return $str;
    }
    
    public function get_score()
    {
        $wrd = build_word();
        $score = 0;
        
        if (check_word($wrd))
        {
            foreach ($this->word as $i => $value) 
                    {
                            $score += letter_score($i);
                    }
                
                    return $score;
        }
    }
    
    public function letter_score($key)
    {
        $letter_values = array();
        
        $letter_values['A'] = 1; 
        $letter_values['B'] = 3; 
        $letter_values['C'] = 3; 
        $letter_values['D'] = 2; 
        $letter_values['E'] = 1; 
        $letter_values['F'] = 4; 
        $letter_values['G'] = 2; 
        $letter_values['H'] = 4; 
        $letter_values['I'] = 1; 
        $letter_values['J'] = 8; 
        $letter_values['K'] = 5; 
        $letter_values['L'] = 1; 
        $letter_values['M'] = 3; 
        $letter_values['N'] = 1; 
        $letter_values['O'] = 1; 
        $letter_values['P'] = 3; 
        $letter_values['Q'] = 10; 
        $letter_values['R'] = 1; 
        $letter_values['S'] = 1; 
        $letter_values['T'] = 1; 
        $letter_values['U'] = 1; 
        $letter_values['V'] = 4; 
        $letter_values['W'] = 4; 
        $letter_values['X'] = 8; 
        $letter_values['Y'] = 4; 
        $letter_values['Z'] = 10; 
        
        return $letter_value($key);
    }
}

?>
