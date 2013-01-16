<?php

class ImageModel {

    protected $imageSrc;
    protected $imagePath;
    protected $image;

    public function __construct() {
        $this->imagePath = Yii::app()->params['imagePath'];
        $this->imageSrc = Yii::app()->params['imageSrc'];
    }

    /**
     *
     * Retrun ImageModel object
     * 
     * @param strings $className
     * @return ImageModel 
     */
    public static function model($className = __CLASS__) {
        return new $className;
    }

    /**
     * This method resize file and returns new path/to/image
     *
     * @param String $filename
     * @param int $width
     * @param int $height
     * @param boolean $watermark
     * @return String new file path
     */
    public function resize($filename, $width, $height, $watermark = false, $alpha = 0) {
        if (!file_exists($this->imagePath . $filename) || !is_file($this->imagePath . $filename)) {
            $filename = 'noimage.jpg';
        }

        $info = pathinfo($filename);
        $extension = $info['extension'];

        $old_image = $filename;
        if ($alpha > 0) {
            $new_image = 'cache/alpha_' . $alpha . substr($filename, 0, strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;
        } else {
            $new_image = 'cache/' . substr($filename, 0, strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;
        }



        if (!file_exists($this->imagePath . $new_image) || (filemtime($this->imagePath . $old_image) > filemtime($this->imagePath . $new_image))) {
            $path = '';

            $directories = explode('/', dirname(str_replace('../', '', $new_image)));

            foreach ($directories as $directory) {
                $path = $path . '/' . $directory;

                if (!file_exists($this->imagePath . $path)) {
                    @mkdir($this->imagePath . $path, 0777);
                }
            }

            $image = new Images($this->imagePath . $old_image);
            $image->resize($width, $height, 127);
            if ($watermark)
                $image->watermark($this->imagePath . 'watermark.png');
            $image->save($this->imagePath . $new_image);
        }

        return $this->imageSrc . $new_image;
    }

    public function prevAdmin($filename) {
        return $this->resize($filename, Yii::app()->params['previewWidth'], Yii::app()->params['previewWidth']);
    }

    /**
     * If file with name 'file' exists, then method saves file wuth name 'file[0,1,2,3...]
     * Method returns new file name
     *
     * @param CUploadedFile $image
     * @return String path/to/image
     */
    public function saveImage(CUploadedFile $image) {
        if ($image) {
            if (file_exists($this->imagePath . $image->getName())) {
                $filename = preg_replace('/^(\S+)\.[a-z]{3}$/si', '$1', $image->getName());
                $extension = $image->getExtensionName();
                $files = glob($this->imagePath . $filename . '*.' . $extension);
                $maxNumber = 0;
                foreach ($files as $file) {
                    $number = (int) preg_replace('/.*?\/' . $filename . '\[(\d*?)\]\.[a-z]{3}$/si', '$1', $file);
                    if ($number > $maxNumber)
                        $maxNumber = $number;
                }
                $maxNumber++;
                if ($image->saveAs($this->imagePath . $filename . '[' . $maxNumber . '].' . $extension)) {
                    return $filename . '[' . $maxNumber . '].' . $extension;
                } else {
                    throw new CHttpException(404, 'Image not saved!');
                }
            } else {
                if ($image->saveAs($this->imagePath . $image->getName())) {
                    return $image->getName();
                } else {
                    throw new CHttpException(404, 'Image not saved! Call to your administrator or try again later!');
                }
            }
        }
    }

    public function deleteImageByName($name) {
        $imagePath = $this->imagePath . $name;
        if (file_exists($imagePath))
            unlink($imagePath);
        $this->clearCacheByName($name);
    }

    public function clearCacheByName($name) {
        preg_match('/^(.*?)\.([a-z0-9]{0,4})$/i', $name, $matches);
        $fileName = $matches[1];
        $extension = $matches[2];
        $cacheImages = glob($this->imagePath . 'cache/' . $fileName . '*.' . $extension);

        if ($cacheImages) {
            foreach ($cacheImages as $cacheImage) {
                if (preg_match('/' . $fileName . '-\d+x\d+\.' . $extension . '/i', $cacheImage)) {
                    unlink($cacheImage);
                }
            }
        }
    }

    public function getImagePath() {
        return $this->imagePath;
    }

    public function getImageSrc() {
        return $this->imageSrc;
    }

}