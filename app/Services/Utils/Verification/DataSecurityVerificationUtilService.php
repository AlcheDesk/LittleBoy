<?php

namespace App\Services\Utils\Verification;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class DataSecurityVerificationUtilService
{

    public function verifyDataSecurity (array $source) : array {

        if (!is_array($source)) {
            $error = ValidationException::withMessages([
                'source' => ['the source is not array']
            ]);
            throw $error;
        }
        if(count($source) < 1){
            $error = ValidationException::withMessages([
                'source' => ['the source array length is 0']
            ]);
            throw $error;
        }
        $returnBrowserFirstNavigate = $this->verifyfirstNavigate($source);
        $returnBrowserWaitInput = $this->verifyWaitInput($source);

        if($returnBrowserFirstNavigate['result'] == false && $returnBrowserWaitInput['result'] == false){
            $returnResult['result'] =false;
            $returnResult['output'] = array_merge($returnBrowserFirstNavigate,$returnBrowserWaitInput);
        }
        else if ($returnBrowserFirstNavigate['result'] == true){
            if ($returnBrowserWaitInput['result']== true){
                $returnResult['result'] =true;
            } else{
                $returnResult['result'] =false;
                $returnResult['output'] = $returnBrowserWaitInput['output'];
            }
        }else {
            $returnResult['result'] =false;
            $returnResult['output'] = $returnBrowserFirstNavigate['output'];
        }
        $returnResult['source'] = $source;
        return $returnResult;
    }

    /**
     * type为webBrowser，第一条步骤的动作必须为navigate，且input为url
     * 如第一条步骤的type为webBrowser，动作为navigate，则校验input的格式必须为url
     * @param array $source
     * @return mixed
     */
    function verifyfirstNavigate(array $source){
        foreach ($source as $key => $instruction){
            $index = $instruction['id'];
            $inputEmpty = '[ input cannot be empty ] ';
            $inputUnreasonable = '[ Unreasonable input ] ';
            if (strcasecmp($instruction['type'], 'WebBrowser') == 0){
                if (strcasecmp($instruction['action'], 'Navigate') == 0){
                    $returnArray['result'] = true;
                }else{
                    //如第一条步骤type为webBrowser，校验动作必须为navigate
                    $returnArray['output'][$index] = $inputUnreasonable . ' instruction id : '.$index. ' ; the first browser action must be Navigate, please check' ;
                    $returnArray['result'] = false;
                }
                break;
            } else{
                $returnArray['result'] = true;
            }
        }
        $returnArray['source'] = $source;
        return $returnArray;
    }

    /**
     *
     * @param array $source
     * @return mixed
     */
    function verifyWaitInput(array $source){
        foreach ($source as $key => $instruction){
            $index = $instruction['id'];
            $inputEmpty = '[ input cannot be empty ] ';
            $inputUnreasonable = '[ Unreasonable input ] ';
            //type为webBrowser
            if (strcasecmp($instruction['type'], 'WebBrowser') == 0){
                if (strcasecmp($instruction['action'], 'Wait') == 0){
                    if (strcmp($instruction['input'],'') != 0 || strcmp($instruction['input'],'null') != 0){
                        $InputOfWait = $instruction['input'];
                        if (is_numeric($InputOfWait) == true){
                            //type为webBrowser，action为wait，input必须为（0,3600]范围内的数字
                            if($InputOfWait > 0 && $InputOfWait <= 3600){
                                $returnArray['result'] = true;
                            } else{
                                $returnArray['output'][$index] = $inputUnreasonable . ' instruction id : '.$index.  '; input of WebBrowser wait input out of range, greater than 0 and less than 3600' ;
                                $returnArray['result'] = false;
                            }
                        } else {
                            $returnArray['output'][$index] = $inputUnreasonable . ' instruction id : '.$index. '; input of WebBrowser wait input is must be numbers, and units are seconds' ;
                            $returnArray['result'] = false;
                        }
                     } else{
                         $returnArray['output'][$index] =  $inputEmpty.' instruction id : '.$index. '; input of WebBrowser wait input can not be null' ;
                         $returnArray['result'] = false;
                     }
                }
                //navigate
                if (strcasecmp($instruction['action'], 'Navigate') == 0){
                    if (strcmp($instruction['input'],'') != 0){
                        $InputOfFirstWebBrowser = $instruction['input'];
                        if (filter_var($InputOfFirstWebBrowser, FILTER_VALIDATE_URL) == false){
                            $returnArray['output'][$index] = $inputUnreasonable . ' instruction id : '.$index. ' ; input of WebBrowser navigate input is not a valid URL' ;
                            $returnArray['result'] = false;
                        } else{
                            $returnArray['result'] = true;
                        }
                    } else{
                        $returnArray['output'][$index] = $inputEmpty.' instruction id : '.$index. '; input of WebBrowser navigate input can not be null' ;
                        $returnArray['result'] = false;
                    }
                }
            }
            //type为javaScript，动作为execute，input不能为空
            if (strcasecmp($instruction['type'], 'JavaScript') == 0){
                if (strcasecmp($instruction['action'], 'Execute') == 0){
                    if (strcmp($instruction['input'],'') == 0 || strcmp($instruction['input'],'null') == 0){
                        $returnArray['output'][$index] =  $inputEmpty.' instruction id : '.$index. '; input of javaScript execute input can not be null' ;
                        $returnArray['result'] = false;

                    } else{
                        $returnArray['result'] = true;
                    }
                }
            }
            //type为sql，动作为execute，input不能为空
            if (strcasecmp($instruction['type'] ,'SQL') == 0){
                if (strcasecmp($instruction['action'] ,'Execute') == 0){
                    if (strcmp($instruction['input'],'') == 0 || strcmp($instruction['input'],'null') == 0){
                        $returnArray['output'][$index] =  $inputEmpty.' instruction id : '.$index. '; input of sql execute input can not be null' ;
                        $returnArray['result'] = false;
                    } else{

                        $returnArray['result'] = true;
                    }
                }
            }
            //type为WebFunction
            if (strcasecmp($instruction['type'], 'webfunction') == 0){
                //elementType为WebButton
                if(strcasecmp($instruction['elementType'], 'WebButton') == 0){
                    if (strcasecmp($instruction['action'], 'DragAndDrop') == 0){
                        if (strcasecmp($instruction['input'], '') != 0 || strcmp($instruction['input'],'null') != 0){
                            $inputOfDragAndDrop = $instruction['input'];
                            if (preg_match('/^(\d+,\d+)$/', $inputOfDragAndDrop)){
                                $returnArray['result'] = true;
                            } else{
                                $returnArray['output'][$index] = $inputUnreasonable . ' instruction id : '.$index.  '; input of webfunction WebButton DragAndDrop input must be a coordinate,likes (2,4)' ;
                                $returnArray['result'] = false;
                            }
                        } else{
                            $returnArray['output'][$index] =  $inputEmpty.' instruction id : '.$index. '; input of webfunction WebButton DragAndDrop input can not be null' ;
                            $returnArray['result'] = false;
                        }
                    }
                }
                //elementType为WebTextbox
                if (strcasecmp($instruction['elementType'], 'WebTextbox') == 0){
                    if (strcasecmp($instruction['action'], 'Enter') == 0 || strcasecmp($instruction['action'], 'enterReadonly') == 0 ||
                        strcasecmp($instruction['action'], 'match') == 0 || strcasecmp($instruction['action'], 'inputContainsPageText') == 0 ||
                        strcasecmp($instruction['action'], 'inputInPageText') == 0){
                        $inputOfTextbox = $instruction['input'];
                        if (strcasecmp($inputOfTextbox,'') == 0){
                            $returnArray['output'][$index] =  $inputEmpty.' instruction id : '.$index. '; input of webfunction WebTextbox input can not be null' ;
                            $returnArray['result'] = false;
                        } else{
                            $returnArray['result'] = true;
                        }
                    }
                }
                //elementType为webDropdown
                if (strcasecmp($instruction['elementType'], 'webDropdown') == 0){
                    if (strcasecmp($instruction['action'], 'select') == 0 ){
                        $inputOfTextbox = $instruction['input'];
                        if (strcasecmp($inputOfTextbox,'') == 0){
                            $returnArray['output'][$index] =  $inputEmpty.' instruction id : '.$index. '; input of webfunction webDropdown select input can not be null' ;
                            $returnArray['result'] = false;
                        } else{
                            $returnArray['result'] = true;
                        }
                    }
                }
                //elementType为webRadio
                if (strcasecmp($instruction['elementType'], 'webRadio') == 0){
                    if (strcasecmp($instruction['action'], 'select') == 0 ){
                        $inputOfTextbox = $instruction['input'];
                        if (strcasecmp($inputOfTextbox,'') == 0){
                            $returnArray['output'][$index] =  $inputEmpty.' instruction id : '.$index. '; input of webfunction webDropdown select input can not be null' ;
                            $returnArray['result'] = false;
                        } else{
                            $returnArray['result'] = true;
                        }
                    }
                }
                //JsExcuteForElement
                if (strcasecmp($instruction['action'], 'JsExcuteForElement') == 0 ){
                    $inputOfJsExcute = $instruction['input'];
                    if (strcasecmp($inputOfJsExcute,'') == 0){
                        $returnArray['output'][$index] = $inputEmpty.' instruction id : '.$index.'; input of webfunction JsExcuteForElement input can not be null' ;
                        $returnArray['result'] = false;
                    } else{
                        $returnArray['result'] = true;
                    }
                }
            }
        }
        $returnArray['source'] = $source;
        return $returnArray;
    }

}
