<?php
/**
 * Created by PhpStorm.
 * User: Helene
 * Date: 30.12.2018
 * Time: 16:37
 */

/**
 * Class UserRequests
 *  getList()
 *  showList()
 *
 *  create($userID, $clanID)
 */

global $db;

use Main\Data;

class UserRequests
{

    /**
     * @var eSafeMySQL
     */
    static $db;

    /**
     * @param $db eSafeMySQL;
     */
    static function setDB($db)
    {
        self::$db = $db;
    }

    public function getList()
    {
        $db = UserRequests::$db;
        return $db->getAll("SELECT * FROM user_requests");
    }

    public function changeStatus( \User\User $user, \Clan\Clan $clan, $status){




    }

    public function create( \User\User $user, \Clan\Clan $clan){
        $db = UserRequests::$db;

        /*//Testing user
        if(empty($userID)){
            return new Data([
                'errText' => 'Unauthorized',
                'errCode' => 401,
            ]);
        }

        $user = $db->getRow("SELECT * FROM users WHERE id=?i", $userID);
        if(!$user) {
            return new Data([
                'errText' => 'Not found : No user',
                'errCode' => 404,
            ]);
        }
        if(!empty($user['clan_id'])){
            return new Data([
                'errText' => 'Forbidden : you are already in clan',
                'errCode' => 403,
            ]);
        }
        // User is OK

        // Testing clan
        if(empty($clanName)){
            return new Data([
                'errText' => 'Bad request : no clan name',
                'errCode' => 400,
            ]);
        }

        $clan = $db->getRow("SELECT * FROM clans WHERE name=?s", $clanName);
        if(!$clan){
            return new Data([
                'errText' => 'Not found : No clan',
                'errCode' => 404,
            ]);
        }

        // Clan is OK*/

        $sql = "SELECT * FROM user_requests WHERE user_id=?i AND clan_id=?i";
        $res = $db->query($sql, $_SESSION['id'], $clan['id']);

        if ( $res ){
            return new Data([
                'errText' => 'Database error : this record already exists',
                'errCode' => 500,
            ]);
        }

        // Everything is OK

        $sql  = "INSERT INTO user_requests (user_id, clan_id, status) VALUES (?i, ?i, 0)";
        $res  = $db->query($sql, $user->getId(), $clan->getId());

        if (!$res) {//Something wrong with mysql
            return new Data([
                'errText'  => 'Database error',
                'errCode'  => 501,
                'response' => $db->getStats(),
            ]);
        }

        return new Data([
            'errText' => 'Created',
            'errCode' => 201
        ]);
    }

    public function iShowList($width, $height)
    {
        $db = self::$db;

        $list = $this->getList();

        ?>

        <div class="userRequest list" style="<?php echo "width : $width; height : $height>"?>">
            <ul>
                <?php
                foreach ($list as $item) {
                    $res = $db->getRow("SELECT * FROM users WHERE id=?i", $item['user_id']);
                    echo "<li> User :".$res['username']." | Status : ".$item['status']."</li>";
                }
                ?>
            </ul>
        </div>

        <?php
    }
}