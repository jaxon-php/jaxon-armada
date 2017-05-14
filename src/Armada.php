<?php

namespace Jaxon\Armada;

class Armada
{
    use \Jaxon\Sentry\Traits\Armada;

    /**
     * The config file path
     * 
     * @var string
     */
    protected $sConfigFile = '';

    /**
     * Initialise the Jaxon module.
     *
     * @return void
     */
    public function __construct()
    {}

    /**
     * Read and set Jaxon options from a config file
     *
     * @return array
     */
    protected function readConfig()
    {
        $sExt = pathinfo($this->sConfigFile, PATHINFO_EXTENSION);
        switch($sExt)
        {
        case 'php':
            return \Jaxon\Config\Php::read($this->sConfigFile, 'lib', 'app');
            break;
        case 'yaml':
        case 'yml':
            return \Jaxon\Config\Yaml::read($this->sConfigFile, 'lib', 'app');
            break;
        case 'json':
            return \Jaxon\Config\Json::read($this->sConfigFile, 'lib', 'app');
            break;
        default:
            $msg = jaxon_trans('config.errors.file.extension', array('path' => $this->sConfigFile));
            throw new \Jaxon\Exception\Config\File($msg);
            break;
        }
    }

    /**
     * Set the config file path.
     *
     * @return void
     */
    public function config($sConfigFile)
    {
        $this->sConfigFile = $sConfigFile;
    }

    /**
     * Set the module specific options for the Jaxon library.
     *
     * @return void
     */
    protected function jaxonSetup()
    {
        // Read config file
        $this->appConfig = $this->readConfig();

        $sentry = jaxon()->sentry();

        // Set the session manager
        $sentry->setSessionManager(function(){
            return new Session();
        });
    }

    /**
     * Set the module specific options for the Jaxon library.
     *
     * This method needs to set at least the Jaxon request URI.
     *
     * @return void
     */
    protected function jaxonCheck()
    {
        // Check the mandatory options
        // Jaxon library settings
        /*$aMandatoryOptions = ['js.app.extern', 'js.app.minify', 'js.app.uri', 'js.app.dir'];
        foreach($aMandatoryOptions as $sOption)
        {
            if(!$jaxon->hasOption($sOption))
            {
                throw new \Jaxon\Exception\Config\Data(jaxon_trans('config.errors.data.missing', array('key' => 'lib:' . $sOption)));
            }
        }*/
        // Jaxon application settings
        /*$aMandatoryOptions = ['controllers.directory', 'controllers.namespace'];
        foreach($aMandatoryOptions as $sOption)
        {
            if(!$this->appConfig->hasOption($sOption))
            {
                throw new \Jaxon\Exception\Config\Data(jaxon_trans('config.errors.data.missing', array('key' => 'app:' . $sOption)));
            }
        }*/
    }

    /**
     * Wrap the Jaxon response into an HTTP response.
     *
     * @param  $code        The HTTP Response code
     *
     * @return HTTP Response
     */
    public function httpResponse($code = '200')
    {
        // Send HTTP Headers
        jaxon()->sendResponse();
    }
}
