<?php
/**
 * Created by PhpStorm.
 * User: Мария
 * Date: 11.10.2016
 * Time: 13:47
 */

namespace app\commands;

use app\objects\NewForum;
use app\objects\Tools;
use Yii;
use yii\console\Controller;
use app\tests\custom\Filters\Filters;
use yii\httpclient\Client;

class TestController extends Controller
{

    public function actionIndex()
    {
        echo 'Controller for tests.'.PHP_EOL;
    }

    public function actionRun()
    {
        #Yii::$app->ruTracker->run();

    }

    public function actionFilters()
    {
        new Filters();
    }

    public function actionDeleteFilter()
    {
        var_dump((new Tools())->deleteFilter('111'));
    }

    public function actionOption()
    {
        $string = "";
        $object = new NewForum();
        $object->stringToFakeArray($string);
    }

    public function actionTest()
    {
        #var_dump((new Tools())->switchOnOff('file'));
    }

    public  function actionHttp()
    {
        $proxyList = [
            ['ip'=>'89.38.148.172', 'port'=>'3128', 'country'=>'Germany', 'type'=>'http'],
            ['ip'=>'213.136.89.121', 'port'=>'3128', 'country'=>'Germany', 'type'=>'http'],
            ['ip'=>'217.61.3.240', 'port'=>'3128', 'country'=>'Germany', 'type'=>'http'],
            ['ip'=>'46.218.85.101', 'port'=>'3129', 'country'=>'France', 'type'=>'http'],
            ['ip'=>'104.238.191.7', 'port'=>'8080', 'country'=>'France', 'type'=>'http'],
            ['ip'=>'195.154.70.11', 'port'=>'3128', 'country'=>'France', 'type'=>'http'],
            ['ip'=>'37.187.100.23', 'port'=>'3128', 'country'=>'France', 'type'=>'http'],
            ['ip'=>'176.31.96.198', 'port'=>'8080', 'country'=>'France', 'type'=>'http'],
            ['ip'=>'5.135.164.181', 'port'=>'3128', 'country'=>'France', 'type'=>'http'],
            ['ip'=>'89.38.149.104', 'port'=>'3128', 'country'=>'France', 'type'=>'http'],
            ['ip'=>'5.135.179.127', 'port'=>'8888', 'country'=>'France', 'type'=>'http'],
            ['ip'=>'51.255.74.112', 'port'=>'3128', 'country'=>'France', 'type'=>'http'],
            ['ip'=>'94.177.232.26', 'port'=>'3128', 'country'=>'France', 'type'=>'http'],
            ['ip'=>'94.177.243.222', 'port'=>'3128', 'country'=>'France', 'type'=>'http'],
            ['ip'=>'185.28.193.95', 'port'=>'8080', 'country'=>'Czech Republic', 'type'=>'http'],
        ];

        foreach ($proxyList as $proxy) {

            $client = new Client();
            $status = false;
            $i = 0;
            do{
                if($i == 3){break;};
                try{
                    $response = $client->createRequest()
                        ->setMethod('get')
                        ->setUrl('http://rutracker.org/forum/index.php')
                        #->setData(['name' => 'John Doe', 'email' => 'johndoe@example.com'])
                        ->setOptions([
                            'proxy' => 'tcp://'.$proxy["ip"].':'.$proxy["port"], // use a Proxy
                            'timeout' => 25, // set timeout to 5 seconds for the case server is not responding
                            'request_fulluri' => true
                        ])->send();

                    file_put_contents( Yii::$app->basePath.DIRECTORY_SEPARATOR.'http'.DIRECTORY_SEPARATOR.time().'.html', $response->getContent());
                    echo 'OK ';
                    echo $proxy["ip"].PHP_EOL;
                    $status = true;
                }catch (\yii\httpclient\Exception $e){
                    echo "Error ";
                    echo $proxy["ip"].PHP_EOL;
                    $i++;
                }
            }while(!$status);

        };
        #var_dump($response->getContent());

        /*
        $opts = array('ftp' => array(
            'proxy' => 'tcp://vbinprst10:8080',
            'request_fulluri'=>true,
            'header' => array(
                "Proxy-Authorization: Basic "
            )
        )
        );
        */
    }
}