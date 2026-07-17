<?php

class Getlist_model extends CI_Model {

    var $title   = '';
    var $content = '';
    var $date    = '';
	public $tableName;

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }


    function getFieldsMultipleConditions($table_name,$get_field_name,$condition,$Key='0')
    {   
      $sql="SELECT $get_field_name FROM $table_name $condition";
      $query = $this->db->query($sql);

      if ($query){
        if($query->num_rows()>0)
        {
            if($Key == '0')
            {
              $DataListArray =array();
              return $query->result(); 
            }
            if($Key == '1')
            {
                $fields=$query->result();
                return $fields[0]->$get_field_name;  
            }
            if($Key == '2')
            {
                $fields=$query->row();
                return $fields;  
            }
        }
        else
        {
            return "";
        }
      }
    }   



    function getDropDownArray($table_name,$get_field_name,$key_field_id,$conditions='',$index='Select')
    {
        if($conditions)
        {
          $this->db->where($conditions);
        }

        $this->db->order_by($get_field_name);
        $DataList = $this->db->get($table_name);
        //print_r($this->db->last_query());
        if($DataList->num_rows>0)
        { 
          $DataListArray =array();
          if($index)
          {
            $DataListArray['']=$index;
          }
         
          foreach ($DataList->result() as $fieldvalue) 
          {
            $DataListArray[$fieldvalue->$key_field_id]=$fieldvalue->$get_field_name;
          }
        }
        else
        {
          $DataListArray['']='No record found';
        }
        
        return $DataListArray;
    }  



    function getDropDownArraySort($table_name,$get_field_name,$key_field_id,$conditions, $sort,$index='Select')
    {

        if($conditions!="")
        {
          $this->db->where($conditions);
        }
        
        if($sort!="")
        {
          $this->db->order_by($sort);
        }


        $DataList = $this->db->get($table_name);
        if($DataList->num_rows>0)
            { 
                $DataListArray =array();
                if($index)
                {
                  $DataListArray['']=$index;
                }
               
                foreach ($DataList->result() as $fieldvalue) {
                $DataListArray[$fieldvalue->$key_field_id]=$fieldvalue->$get_field_name;
            }
        }
        else
        {
          $DataListArray[0]='No record found';
        }
        
        return $DataListArray;
    }




 function convert_number($number)
{
    if (($number < 0) || ($number > 999999999))
    {
    throw new Exception("Number is out of range");
    }

    $Gn = floor($number / 1000000);  /* Millions (giga) */
    $number -= $Gn * 1000000;
    $kn = floor($number / 1000);     /* Thousands (kilo) */
    $number -= $kn * 1000;
    $Hn = floor($number / 100);      /* Hundreds (hecto) */
    $number -= $Hn * 100;
    $Dn = floor($number / 10);       /* Tens (deca) */
    $n = $number % 10;               /* Ones */

    $res = "";

    if ($Gn)
    {
        $res .= $this->convert_number($Gn) . " Million";
    }

    if ($kn)
    {
        $res .= (empty($res) ? "" : " ") .$this->convert_number($kn) . " Thousand";
    }

    if ($Hn)
    {
        $res .= (empty($res) ? "" : " ") .$this->convert_number($Hn) . " Hundred";
    }

    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six",
        "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen",
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen",
        "Nineteen");
    $tens = array("", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty",
        "Seventy", "Eigthy", "Ninety");

    if ($Dn || $n)
    {
        if (!empty($res))
        {
            $res .= " and ";
        }

        if ($Dn < 2)
        {
            $res .= $ones[$Dn * 10 + $n];
        }
        else
        {
            $res .= $tens[$Dn];

            if ($n)
            {
                $res .= "-" . $ones[$n];
            }
        }
    }

    if (empty($res))
    {
        $res = "zero";
    }

    return $res;
} 



function ExchangeCurrency($CurrencyFrom,$CurrencyTo,$Amount=0)
{
  $ExchangeRate = $Amount; 
  if($CurrencyFrom != $CurrencyTo)
  {
    $condition = " WHERE CurrencyFrom =  '$CurrencyFrom' AND CurrencyTo = '$CurrencyTo' ORDER BY UpdatedOn DESC";
    $varExchnageRate = $this->getlist_model->getFieldsMultipleConditions('tbl_currency_rates_history','CurrencyValue',$condition,1); 
    if($varExchnageRate)
    {
      $ExchangeRate = (float)$Amount*(float)$varExchnageRate;
    }
  }
  return $ExchangeRate;
}   



function exchange_rates($CurrencyFrom,$CurrencyTo,$Amount=0)
{
  $ExchangeRate = $Amount; 
  if($CurrencyFrom != $CurrencyTo)
  {
    $condition = " WHERE CurrencyFrom =  '$CurrencyFrom' AND CurrencyTo = '$CurrencyTo' ORDER BY UpdatedOn DESC";
    $varExchnageRate = $this->getlist_model->getFieldsMultipleConditions('tbl_currency_rates','CurrencyValue',$condition,1); 
    print_r($this->db->last_query());
    if($varExchnageRate)
    {
      $ExchangeRate = (float)$Amount*(float)$varExchnageRate;
    }
  }
  return $ExchangeRate;
}   


function randomPassword() 
{
  $alphabet = "abcdefghjkmnpqrstuwxyzABCDEFGHJKMNPQRSTUWXYZ123456789";
  $pass = array(); //remember to declare $pass as an array
  $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
  for ($i = 0; $i < 8; $i++) 
  {
    $n = rand(0, $alphaLength);
    $pass[] = $alphabet[$n];
  }
  return implode($pass); //turn the array into a string
}


}
 ?>