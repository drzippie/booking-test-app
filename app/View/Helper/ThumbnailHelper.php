<?php
/**
 * Helper to generate thumbnail images dynamically by saving them to the cache.
 * Alternative to phpthumb.
 *
 * Inspired in http://net.tutsplus.com/tutorials/php/image-resizing-made-easy-with-php/
 *
 * @author Emerson Soares (dev.emerson@gmail.com)
 * @filesource https://github.com/emersonsoares/ThumbnailsHelper-for-CakePHP
 */
App::uses('HtmlHelper', 'View/Helper');

class  ThumbnailHelper extends HtmlHelper {
 
    private $defaults = array(
        'folder' => 'thumbnails',
        'width' => 150,
        'height' => 225,
        'quality' => 80,
        'resize' => 'auto',
        'cachePath' => '',
        'srcImage' => '',
        'srcHeight' => '',
        'srcWidth' => '',
        'openedImage' => '',
        'imageResized' => '',
        'folderRelative' => '',
        'shadow' => false ,
        'basename' => '',
    );
    private $baseCRC = '1' ;
    private $command = '/usr/bin/convert ' ;
    public $settings = array();

    /**
     * Default Constructor
     *
     * @param View $View The View this helper is being attached to.
     * @param array $settings Configuration settings for the helper.
     */
    public function __construct(View $View, $settings = array()) {
        parent::__construct($View, $settings);
        $this->defaults = array_merge($this->defaults, $settings);
    }

    /**
     *
     * @param string $image Caminho da imagem no servidor
     * @param array $params Parametros de configuração do Thumbnail
     * @param array $options Parametros de configuração da tag <img/>
     * @return string Retorna uma tag imagem, configurada de acordo com os parametros recebidos.
     */
    public function render($image, $params, $options = array()) {
        $result = null;
        $this->setup($image, $params);
        // echo $this->settings['folder'] . $this->settings['cachePath'] . DS. $this->settings['outImage'] ; 
        $cacheFile = $this->settings['folder'] . DS.  $this->settings['cachePath'] . DS.  $this->settings['outImage']  ;
          if (is_file( $cacheFile )    )  {
            $result = $this->image($this->openCachedImage(), $options);
          } else if ($this->openSrcImage()) {
          //   $this->resizeImage();
            $this->saveImgCache();
            $result = $this->image($this->settings['folderRelative'] . DS . $this->settings['cachePath'] . DS . $this->settings['outImage'], $options);
        }
        $this->settings = array();
        return $result;
    }

      public function getUrl($image, $params ) {
        $result = null;
        $this->setup($image, $params);
        // echo $this->settings['folder'] . $this->settings['cachePath'] . DS. $this->settings['outImage'] ; 
        $cacheFile = $this->settings['folder'] . DS.  $this->settings['cachePath'] . DS.  $this->settings['outImage']  ;

        if (is_file( $cacheFile )    )  {
            $result =  $this->openCachedImage() ;
          } else if ($this->openSrcImage()) {
            // $this->resizeImage();
            $this->saveImgCache();
            $result =  $this->settings['folderRelative'] . DS . $this->settings['cachePath'] . DS . $this->settings['outImage'] ;
        }
        $this->settings = array();
        return '/img/' . $result;
    }

    private function setup($image, $params) {
        $this->settings = array_merge($this->defaults, $params);
        $this->settings['basename'] = basename($image);
      //   $this->settings['outImage']  = crc32( $image ) . '_' . $this->settings['basename']  ;

          $this->settings['outImage']  = substr( md5( json_encode( $this->settings)) , 0, 5 ) 
            . '_'  . substr( md5( $this->baseCRC .   crc32( $image ) . '_' . $this->settings['basename'] ), 2,12) . '.jpg' ;

        if (strpos($image, '/') === 0) {
            $this->settings['srcImage'] = substr($image, 1);
        } else {
            $this->settings['srcImage'] = 'img' . DS . $image;
        }
        $this->settings['folderRelative'] = $this->settings['folder'];
        if (strpos($this->settings['folder'], '/') === 0) {
            $this->settings['folder'] = substr($this->settings['folder'], 1);
        } else {
            $this->settings['folder'] = 'img' . DS . $this->settings['folder'];
        }
        $this->settings['folder'] = WWW_ROOT . $this->settings['folder'];

        if ($this->settings['cachePath']) {
            $this->settings['cachePath'] .= DS;
        }
        // $cachePath = abs( crc32( 'd9' . json_encode( $this->settings)));

        // $this->settings['cachePath'] .=  $cachePath;
    }

    private function openCachedImage() {
        return $this->settings['folderRelative'] . DS .  $this->settings['cachePath'] . DS . $this->settings['outImage'];
    }

    private function openSrcImage() {
      $image_path = WWW_ROOT . $this->settings['srcImage'];
      if (is_file($image_path)) {
          list($width, $heigth) = getimagesize($image_path);

          $this->settings['srcWidth'] = $width;
          $this->settings['srcHeight'] = $heigth;

           return true;
      } else {
          return false;
      }
    }

    private function saveImgCache() {

        $options = $this->getDimensions();
        $filename = $this->settings['outImage'];

        $sizeDestino =  $options['optimalWidth'] . 'x' .$options['optimalHeight']  ;
        $comando = ' -resize ' . $sizeDestino . '^ -gravity center -extent ' . $sizeDestino ; //  .' -unsharp 0x2  -quality 80 ' ;
        $comando .= ' -unsharp 0x1  -quality ' . $this->settings['quality'] . ' ' ;
   
        if ( $this->settings['shadow']) {
        $comando .= ' -bordercolor white -border 0 \( +clone -background black -shadow 80x3+2+2 \) +swap -background white -layers merge +repage ' ;
        } 

        $extension = strtolower(strrchr($this->settings['folder'] . $this->settings['srcImage'], '.'));

        if (!file_exists($this->settings['folder'] . DS . $this->settings['cachePath'])) {
            mkdir($this->settings['folder'] . DS . $this->settings['cachePath'], 0777, true);
        }

        $comando =  $this->command . '"' .   (   WWW_ROOT .  $this->settings['srcImage'] )  . '"' 
             . $comando . 
            '"' .  ( $this->settings['folder'] . DS . $this->settings['cachePath'] . DS . $filename )  . '"'; 
        //Debugger::dump( $comando );
        shell_exec(  $comando )   ;
         
        //  die( $comando ) ;


    }

     

     
 

    private function getDimensions() {

        switch ($this->settings['resize']) {
            case 'exact':
                $optimalWidth = $this->settings['width'];
                $optimalHeight = $this->settings['height'];
                break;
            case 'portrait':
                $optimalWidth = $this->getSizeByFixedHeight($this->settings['height']);
                $optimalHeight = $this->settings['height'];
                break;
            case 'landscape':
                $optimalWidth = $this->settings['width'];
                $optimalHeight = $this->getSizeByFixedWidth($this->settings['width']);
                break;
            case 'auto':
                $optionArray = $this->getSizeByAuto($this->settings['width'], $this->settings['height']);
                $optimalWidth = $optionArray['optimalWidth'];
                $optimalHeight = $optionArray['optimalHeight'];
                break;
            case 'crop':
                 $optimalWidth = $this->settings['width'];
                $optimalHeight = $this->settings['height'];
                break;
        }
        return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
    }

    private function getSizeByFixedHeight($newHeight) {
        $ratio = $this->settings['srcWidth'] / $this->settings['srcHeight'];
        $newWidth = $newHeight * $ratio;
        return $newWidth;
    }

    private function getSizeByFixedWidth($newWidth) {
        $ratio = $this->settings['srcHeight'] / $this->settings['srcWidth'];
        $newHeight = $newWidth * $ratio;
        return $newHeight;
    }
 
    private function getSizeByAuto($newWidth, $newHeight) {
        if ($this->settings['srcHeight'] > $this->settings['srcWidth']) {
            $newHeight = $newWidth ;
            $optimalWidth = $this->getSizeByFixedHeight($newHeight);
            $optimalHeight = $newHeight;
        } else {
         
            if ($newHeight < $newWidth) {
                $optimalWidth = $newWidth;
                $optimalHeight = $this->getSizeByFixedWidth($newWidth);
            } else if ($newHeight > $newWidth) {
                $optimalWidth = $this->getSizeByFixedHeight($newHeight);
                $optimalHeight = $newHeight;
            } else {
                $optimalWidth = $newWidth;
                $optimalHeight = $newHeight;
            }
        }

        return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
    }

    private function getOptimalCrop($newWidth, $newHeight) {

        $heightRatio = $this->settings['srcHeight'] / $newHeight;
        $widthRatio = $this->settings['srcWidth'] / $newWidth;

        if ($heightRatio < $widthRatio) {
            $optimalRatio = $heightRatio;
        } else {
            $optimalRatio = $widthRatio;
        }

        $optimalHeight = $this->settings['srcHeight'] / $optimalRatio;
        $optimalWidth = $this->settings['srcWidth'] / $optimalRatio;

        return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
    }

 }
