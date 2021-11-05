
 
        <?php
            $questionsFile = '../xml/UserCounter.xml';
            if (file_exists($questionsFile)) {
                    $xml = simplexml_load_file($questionsFile);
                }
            if ($xml) {
                    $counter=$xml->xpath('/cantidad');
                    echo $counter[0]->numero;
                }
           
            
        ?>

