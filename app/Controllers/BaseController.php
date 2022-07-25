<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;
    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['common_helper'];
    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        // Preload any models, libraries, etc, here.
        // E.g.: $this->session = \Config\Services::session();
    }
    public function isJSON($string)
    {        
        $valid = is_string($string) && is_array(json_decode($string, true)) ? true : false;

        if (!$valid) {
            $this->response_to_json(FALSE, "Not JSON", 401);
        }
    }
    /* Process json from request */
    public function extract_json($key)
    {
        return json_decode($key, TRUE);
    }
    /* Methods to check all necessary fields inside a requested post body */
    public function validateArray($keys, $arr)
    {
        return !array_diff_key(array_flip($keys), $arr);
    }
    /*
     Set response message
     response_to_json = set_response
    */    
    public function response_to_json($success = TRUE, $message = "success", $data = NULL, $extraField = NULL, $extraData = NULL)
    {
        $response = ["success" => $success, "message" => $message, "data" => $data];
        if ($extraField != NULL && $extraData != NULL) {
            $response[$extraField] = $extraData;
        }
        print json_encode($response);
        die;
    }
    public function responseJSON($data)
    {
        print json_encode($data);
        die;
    }
}
