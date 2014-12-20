<?php
/**
 * CodeByJoe Ltd :: http://www.codebyjoe.com
 *
 * @category CodeByJoe
 * @package CodeByJoe_Core
 * @author Joseph McDermott <code@josephmcdermott.co.uk>
 * @license http://choosealicense.com/licenses/mit/ MIT License
 */
class CodeByJoe_Core_Model_File extends Mage_Core_Helper_Abstract
{
    /**
     * @param string $filepath
     * @return string
     * @throws Exception
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function readFile($filepath)
    {
        $io = $this->loadFile($filepath);

        try {
            $string = '';
            
            while (false !== ($_chunk = $io->streamRead())) {
                $string .= $_chunk;
            }

            $io->streamClose();
        } catch (Exception $e) {
            $io->streamClose();

            throw $e;
        }

        return $string;
    }

    /**
     * @param string $filepath
     * @param bool $firstRowIsHeader
     * @return array
     * @throws Exception
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function readCsv($filepath, $firstRowIsHeader = true)
    {
        $io = $this->loadFile($filepath);

        try {
            if ($firstRowIsHeader) {
                $headers = $io->streamReadCsv();
            }

            $data = array();
            while (false !== ($line = $io->streamReadCsv())) {
                if (empty($line)) {
                    continue;
                }

                if ($firstRowIsHeader) {
                    $data[] = array_combine($headers, $line);
                } else {
                    $data[] = $line;
                }
            }

            $io->streamClose();
        } catch (Exception $e) {
            $io->streamClose();

            throw $e;
        }

        return $data;
    }

    /**
     * @param string $filepath
     * @return Varien_Io_File
     * @throws Exception
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function loadFile($filepath)
    {
        $io = new Varien_Io_File();
        $info = pathinfo($filepath);
        $io->open(array('path' => $info['dirname']));
        $io->streamOpen($info['basename'], 'r');

        return $io;
    }
}