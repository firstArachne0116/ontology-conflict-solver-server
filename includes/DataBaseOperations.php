<?php
    class DataBaseOperations{

    	private $con;
    	function __construct(){

    		require_once dirname(__FILE__). '/DataBaseConnect.php';
    		$db = new DataBaseConnect();
    		$this->con = $db->connect();
    	}

        /****************************************************************************
        *
        * Functions for aurthor Table
        *
        * 1) createAuthor($username, $pass, $firstname, $lastname, $email)
        * 2) authorLogin($username, $pass)
        * 3) isAuthorExist($username, $email)
        * 4) getAuthorByUsername($username)
        *
        *****************************************************************************/

        public function createAuthor($username, $pass, $firstname, $lastname, $email){
            
            if($this->isAuthorExist($username,$email)){

                return 0;

            }else{
                $password = md5($pass);
                $stmt = $this->con->prepare("INSERT INTO `Author` (`authorId`,`username`,`password`,`firstname`,`lastname`,`email`) VALUES (NULL, ?, ?, ?, ?, ?);");
                $stmt->bind_param("sssss",$username,$password,$firstname,$lastname,$email);
            
                if($stmt->execute()){
                    return 1;
                }else{
                    return 2;
                }
            }
        }

        public function authorLogin($username, $pass){
            $password = md5($pass);
            $stmt = $this->con->prepare("SELECT authorId FROM aurthor WHERE username = ? AND password = ?");
            $stmt->bind_param("ss",$username,$password);
            $stmt->execute();
            $stmt->store_result(); 
            return $stmt->num_rows > 0; 
        }

        private function isAuthorExist($username, $email){
            $stmt = $this->con->prepare("SELECT authorId FROM aurthor WHERE username = ? OR email = ?");
            $stmt->bind_param("ss", $username, $email);
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows > 0; 
        }
        
        public function getAuthorByUsername($username){
            $stmt = $this->con->prepare("SELECT * FROM aurthor WHERE username = ?");
            $stmt->bind_param("s",$username);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }

        /****************************************************************************
        *
        * Functions for expert Table
        *
        * 1) createExpert($username, $pass, $firstname, $lastname, $email)
        * 2) expertLogin($username, $pass)
        * 3) isExpertExist($username, $email)
        * 4) getExpertByUsername($username)
        * 5) getExpertUsernameById($expertId)
        * 6) getExpertsByConflict($termId, $expertId)
        * 7) function setTasksToExpert()
        *
        *****************************************************************************/

    	public function createExpert($username, $pass, $firstname, $lastname, $email){
            if($this->isExpertExist($username,$email)){
                return 0;
            }else{
                $password = md5($pass);
                $stmt = $this->con->prepare("INSERT INTO `expert` (`expertId`,`username`,`password`,`firstname`,`lastname`,`email`) VALUES (NULL, ?, ?, ?, ?, ?);");
    		    $stmt->bind_param("sssss",$username,$password,$firstname,$lastname,$email);
    		
                if($stmt->execute()){
    			    return 1;
    		    }else{
                    return 2;
    		    }
    	    }
        }

        public function expertLogin($username, $pass){
            $password = md5($pass);
            $stmt = $this->con->prepare("SELECT expertId FROM expert WHERE username = '$username' AND password = '$password'");
            if (!$stmt)
            {
                echo "SELECT expertId FROM expert WHERE username = '$username' AND password = '$password'";
                return 0;
            }
            else{
                $stmt->execute();
                $stmt->store_result(); 
            }
            return $stmt->num_rows > 0; 
        }

        private function isExpertExist($username, $email){
            $stmt = $this->con->prepare("SELECT expertId FROM expert WHERE username = ? OR email = ?");
            $stmt->bind_param("ss", $username, $email);
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows > 0; 
        }
        
        public function getExpertByUsername($username){
            $stmt = $this->con->prepare("SELECT * FROM expert WHERE username = ?");
            $stmt->bind_param("s",$username);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }

        public function getExpertUsernameById($expertId){
            $stmt = $this->con->prepare("SELECT username FROM expert WHERE expertId = ?");
            $stmt->bind_param("s",$expertId);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }

        // public function getExpertsTokenByConflict($termId, $expertId){
        //     $stmt = $this->con->prepare("
        //         SELECT
        //             expert.token as token 
        //         FROM expert 
        //         JOIN J_Conflict_Expert on J_Conflict_Expert.expertId = expert.expertId 
        //         WHERE J_Conflict_Expert.termId = ? AND expert.expertId != ?
        //     ");
        //     $stmt->bind_param("ss",$termId, $expertId);
        //     $stmt->execute();
        //     return $stmt->get_result();
        // }

        public function getTokenByExpertId($expertId){
            $stmt = $this->con->prepare("
                SELECT
                    expert.token as username,
                    expert.token as token 
                FROM expert 
                WHERE expert.expertId != ?
            ");
            $stmt->bind_param("ss",$termId, $expertId);
            $stmt->execute();
            return $stmt->get_result();
        }

        public function setTasksToExpert(){
            $expertId = mysqli_insert_id($this->con);

            $stmt = $this->con->prepare("
                SELECT
                    confusingterm.termId as termId 
                FROM confusingterm 
            ");
            $stmt->execute();
            $results = $stmt->get_result();

            while( $termId = $results->fetch_assoc()) {
                $stmt = $this->con->prepare("
                    INSERT INTO `CategorySolution` VALUES (NULL, ?, ?, 0, '', '', '')
                ");
                $stmt->bind_param("ss", $expertId, $termId['termId']);
                $stmt->execute();
            }
            return $expertId; 
        }

        /****************************************************************************
        *
        * Functions for the other database operations
        *
        *  1) getTermByConflict($termId)
        *  2) getOptions($termId){
        *  3) getOptionImages($termId)
        *  4) getSolvedTasks($expertId)
        *  5) getUnsolvedTasks($expertId)
        *  6) countSolvedConflicts($termId)
        *  7) countUnsolvedConflictsByExpert($expertId)
        *  8) submitDecision($choice, $writtenComment, $voiceComment)
        *  9) isExpertRegistered($expertId)
        * 10) registerToken($expertId, $token)
        * 11) populate_J_Conflict_Expert_Choice($termId, $expertId)
        * 12) populate_J_Conflict_Expert($termId, $expertId)
        * 13) sendNotification($tokens, $message)
        *
        *****************************************************************************/
        public function getTermByConflict($termId){

            $stmt = $this->con->prepare("
                SELECT   
                    confusingterm.term as term
                FROM  confusingterm.termId = ?");
            $stmt->bind_param("s",$termId);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }

        public function getOptions($termId){
            $stmt = $this->con->prepare("
                SELECT   
                    confusingterm.term as term,
                    option_.option_ as option_,
                    option_.definition as definition,
                    option_.image_link as image_link
                FROM  j_confusingterm_option 
                JOIN  confusingterm on j_confusingterm_option.termId = confusingterm.termId
                JOIN  option_       on j_confusingterm_option.optionId = option_.optionId
                WHERE confusingterm.termId = ?");
            $stmt->bind_param("s",$termId);
            $stmt->execute();
            return $stmt->get_result();
        }

        public function getSentences($termId) {
            $stmt = $this->con->prepare("
                SELECT id, sentence
                FROM  sentence
                WHERE termId = ?");
            $stmt->bind_param("s",$termId);
            $stmt->execute();
            return $stmt->get_result();
        }
        
        public function getDefinitions($termId, $expertId) {
            $stmt = $this->con->prepare("
                SELECT id, definition
                FROM  definition
                WHERE termId = ? and (expertId is NULL or expertId = ?)");
            $stmt->bind_param("ss",$termId, $expertId);
            $stmt->execute();
            return $stmt->get_result();
        }

        public function getApproveData($termId, $expertId) {
            $stmt = $this->con->prepare("
                SELECT DISTINCT synonymsolution.sentenceId, synonymsolution.definitionId
                FROM  sentence, synonymsolution
                WHERE sentence.termId = ? and synonymsolution.expertId = ?");
            $stmt->bind_param("ss",$termId, $expertId);
            $stmt->execute();
            return $stmt->get_result();
        }

        public function setApproveData($expertId, $sentenceIds, $definitionIds) {

            for( $i = 0 ; $i < count($sentenceIds) ; $i ++ ) {
                $stmt = $this->con->prepare("
                    INSERT INTO synonymsolution
                    VALUES(NULL, ?, ?, ?);
                ");
                $stmt->bind_param("sss", $sentenceIds[$i], $definitionIds[$i], $expertId);
                $stmt->execute();
            }

            return true;
        }

        public function addDefinition($termId, $expertId, $definition){
            $stmt = $this->con->prepare("
                INSERT INTO definition
                VALUES(NULL, ?, ?, ?);
            ");
            $stmt->bind_param("sss",$definition, $termId, $expertId);
            $stmt->execute();
            return $stmt->get_result();
        }

        public function getOptionImages($termId){
            $stmt = $this->con->prepare("
                SELECT   
                    option_.picture as photo
                FROM  j_confusingterm_option 
                JOIN  confusingterm on j_confusingterm_option.termId = confusingterm.termId
                JOIN  option_       on j_confusingterm_option.optionId = option_.optionId                
                WHERE confusingterm.termId = ?");
            $stmt->bind_param("s",$termId);
            $stmt->execute();
            return $stmt->get_result();
        }        

        public function getSolvedCategoryTask($expertId){
            $stmt = $this->con->prepare("
                SELECT DISTINCT 
                    confusingterm.termId as termId,
                    confusingterm.term as term,
                    confusingterm.data as data
                FROM confusingterm, categorysolution
                WHERE confusingterm.termId = categorysolution.termId and confusingterm.type='category' and categorysolution.expertId = ?
                ORDER BY term ASC
            ;");
            $stmt->bind_param("s",$expertId);
            $stmt->execute();
            return $stmt->get_result();
        }

        public function getUnsolvedCategoryTask($expertId){
            $stmt = $this->con->prepare("
                SELECT DISTINCT 
                    confusingterm.termId as termId,
                    confusingterm.term as term,
                    confusingterm.data as data
                FROM confusingterm
                WHERE confusingterm.type='category' and confusingterm.termId not in
                    (
                        SELECT DISTINCT
                            categorysolution.termId
                        FROM categorysolution
                        WHERE categorysolution.expertId = ?
                    )
                ORDER BY term ASC
            ;");
            $stmt->bind_param("s",$expertId);
            $stmt->execute();
            return $stmt->get_result();
        }

        public function getApproveTask($expertId){
            $stmt = $this->con->prepare("
                SELECT DISTINCT 
                    confusingterm.term as term, 
                    confusingterm.termId as termId,
                    confusingterm.data as data,
                    Count(DISTINCT sentence.id) as sentenceCount,
                    SUM(CASE WHEN synonymsolution.expertId=? THEN 1 ELSE 0 END) != 0 as isSolved
                FROM confusingterm
                    INNER JOIN sentence on confusingterm.termId = sentence.termId
                    LEFT JOIN synonymsolution on sentence.id = synonymsolution.sentenceId
                where confusingterm.type='synonym'
                GROUP BY termId
                ORDER BY term ASC
            ;");
            $stmt->bind_param("s",$expertId);        
            $stmt->execute();
            return $stmt->get_result();
        }
        
        public function getAddTermTasks($expertId){
            $stmt = $this->con->prepare("
                SELECT DISTINCT 
                    confusingterm.term as term, 
                    confusingterm.termId as termId,
                    confusingterm.data as data,
                    SUM(CASE WHEN addtermsolution.expertId=? THEN 1 ELSE 0 END) != 0 as isSolved
                FROM confusingterm
                    LEFT JOIN addtermsolution on addtermsolution.termId = confusingterm.termId
                where confusingterm.type='addTerm'
                GROUP BY termId
                ORDER BY term ASC
            ;");
            $stmt->bind_param("s",$expertId);
            $stmt->execute();
            return $stmt->get_result();
        }

        public function countSolvedConflicts($termId){
            $stmt = $this->con->prepare("
                SELECT COUNT(expertId)
                FROM categorysolution
                WHERE termId = ?
            ;");
            $stmt->bind_param("s",$termId);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }

        public function countSolvedApproveConflicts($termId){
            $stmt = $this->con->prepare("
                SELECT DISTINCT
                    synonymsolution.expertId
                FROM confusingterm
                    INNER JOIN sentence on confusingterm.termId = sentence.termId
                    INNER JOIN synonymsolution on sentence.id = synonymsolution.sentenceId
                WHERE sentence.termId = $termId
                GROUP BY synonymsolution.expertId
            ;");
            $stmt->execute();
            return $stmt->get_result()->num_rows;
        }

        public function countSolvedAddTermConflicts($termId){
            $stmt = $this->con->prepare("
                SELECT COUNT(expertId)
                FROM addtermsolution
                WHERE termId = ?
            ;");
            $stmt->bind_param("s",$termId);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }

         public function countUnsolvedConflictsByExpert($expertId){
            $stmt = $this->con->prepare("
                SELECT COUNT(termId)
                FROM confusingterm
                WHERE termId not in (
                    SELECT termId
                    FROM categorysolution
                    WHERE expertId = ?
                ) and termId not in (
                    SELECT DISTINCT termId
                    FROM sentence, synonymsolution
                    WHERE sentence.id = synonymsolution.sentenceId and synonymsolution.expertId = ?
                ) and termId not in (
                    SELECT DISTINCT termId
                    FROM addtermsolution
                    WHERE expertId = ?
                )
            ;");
            $stmt->bind_param("sss", $expertId, $expertId, $expertId);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }


        public function submitDecision($termId, $expertId, $choice, $writtenComment, $voiceComment){
            $stmt = $this->con->prepare("
                DELETE FROM `CategorySolution` where termId = ? and expertId = ?;
            ");
            $stmt->bind_param("ss", $termId, $expertId);

            if($stmt->execute()){

                $stmt = $this->con->prepare("
                    INSERT INTO `CategorySolution` VALUES(NULL, ?, ?, ?, ?, ?);
                ");
                $stmt->bind_param("sssss", $expertId, $termId, $choice, $writtenComment, $voiceComment);

                if($stmt->execute()){
                    return 1;
                }
            }
            return 2;
        }

        public function isExpertRegistered($expertId){
            $stmt = $this->con->prepare("SELECT token FROM expert WHERE expertId = ?");
            $stmt->bind_param("s",$expertId);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if( is_null( $row["token"] ) ){
                return 1;
            }else{
                return 2;
            }
        }

        public function registerToken($expertId, $token){
            $stmt = $this->con->prepare("UPDATE `Expert` SET token = ? WHERE expertId = ?");
            $stmt->bind_param("ss",$token,$expertId);
            
            if($stmt->execute()){
                return 1;
            }else{
                return 2;
            }
        }

        // public function populate_J_Conflict_Expert_Choice($termId, $expertId){
        //     $choiceId = mysqli_insert_id($this->con);
        //     $stmt = $this->con->prepare("INSERT INTO `J_Conflict_Expert_Choice` (`termId`,`expertId`,`choiceId`) VALUES (?, ?, ?);");
        //     $stmt->bind_param("sss",$termId,$expertId,$choiceId);
            
        //     if($stmt->execute()){
        //         return $choiceId;
        //     }else{
        //         return -1;
        //     }
        // }

        // public function populate_J_Conflict_Expert($termId, $expertId){
                     
        //     $isSolved = 1;
        //     $stmt = $this->con->prepare("
        //                                  UPDATE J_Conflict_Expert 
        //                                  SET isSolved = ? 
        //                                  WHERE termId = ? AND expertId = ?");
        //      $stmt->bind_param("sss",$isSolved,$termId,$expertId);
            
        //     if($stmt->execute()){
        //         return 1;
        //     }else{
        //         return 2;
        //     }
        // }

        public function getAllTokens(){
                     
            $stmt = $this->con->prepare("SELECT token FROM expert");
             $stmt->execute();
            return $stmt->get_result();
        }


        public function sendNotification($tokens, $message){
            $url = 'https://fcm.googleapis.com/fcm/send';
            $fields = array('registration_ids' => $tokens,
                        'data' => $message );
            $headers = array('Authorization:key = AAAAYXS_iEo:APA91bGZ50RhB0sZIBf6vmXohxOd_wJsDVCQPJCMeqtujIfG9JhLPUpA5C4Q_OFW-nacNXHfoSJPjJKMagr54b9i4JUFpcXocf2oAGzrVaTMsKpBNufnNAGRRQrO-CHGJ3eSdjnv9twF','Content-Type: application/json');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
             $result = curl_exec($ch);
            
            if ($result === FALSE) {
                die('Curl failed: ' . curl_error($ch));
            }
            curl_close($ch);
            return $result;
        }    
    }
?>
