<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!--

Model and Controller Generator for PHP CodeIgniter
Developed by: Dixanta Bahadur Shrestha
http://www.creatorsnepal.com
contact: dixanta@creatorsnepal.com

This program comes with no warranty. So please you it at your won risk.
-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Model Controller Generator Version 1.0</title>
</head>

<body>
<form action="" method="post">
<table width="400" border="1">
  <tr>
    <td colspan="2">MVC Model Controller Generator</td>
    </tr>
  <tr>
    <td>Host Name:</td>
    <td><input type="text" name="txthostname" id="txthostname" /></td>
  </tr>
  <tr>
    <td>User Name:</td>
    <td><input type="text" name="txtusername" id="txtusername" /></td>
  </tr>
  <tr>
    <td>Password:</td>
    <td><input type="text" name="txtpassword" id="txtpassword" /></td>
  </tr>
  <tr>
    <td>Database Name:</td>
    <td><input type="text" name="txtdbname" id="txtdbname" /></td>
  </tr>
  <tr>
    <td>Table Prefix:</td>
    <td><input type="text" name="txtprefix" id="txtprefix" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="btnsubmit" id="btnsubmit" value="Generate" /></td>
  </tr>
</table>
</form>

<?php
	if(isset($_POST['btnsubmit']))
	{
		$host_name=$_POST['txthostname'];
		$user_name=$_POST['txtusername'];
		$password=$_POST['txtpassword'];
		$db_name=$_POST['txtdbname'];
		$prefix=$_POST['txtprefix'];
		
		$c_name="controller";
		$m_name="models";
		
		if(!is_dir($db_name))
		{
			mkdir($db_name);
			
		}
		$c_path=$db_name ."/controller";
		$m_path=$db_name ."/models";
		
		if(!is_dir($c_path))
		{
			mkdir($c_path);
		}
		
		if(!is_dir($m_path))
		{
			mkdir($m_path);
		}
		
		$conn=mysql_connect($host_name,$user_name,$password);
		mysql_select_db($db_name,$conn);
		
		$sql='show tables';
		
		$result=mysql_query($sql,$conn);
		
		while($row=mysql_fetch_row($result))
		{
			$fname=str_replace($prefix,'',$row[0]);
			$file=fopen($c_path.'/'.$fname.'.php','w+');
			
			$content="<?php\n\n";
			$content.="\tclass " .ucfirst($fname) . " extends Controller{\n\n";
			$content.="\t\tfunction __construct(){\n";
			$content.="\t\t\tparent::Controller();\n";
			$content.="\t\t\t\$this->load->model('".ucfirst($fname)."_model');\n";
			$content.="\t\t}\n\n";
			
			$content.="\t\tfunction index(){\n";
			$content.="\t\t}\n";
			$content.="\t}\n";
			
			fwrite($file,$content);		  
			fclose($file);
			
			$file=fopen($m_path.'/'.$fname.'_model.php','w+');
			$content="<?php\n\n";
			$content.="\tclass " .ucfirst($fname) . "_model extends Model{\n\n";
			
			$table_name=strtolower($prefix.$fname);
			$sql="desc " .$table_name;
			
			$resultrow=mysql_query($sql,$conn);
			while($fld=mysql_fetch_array($resultrow))
			{
				$content.="\t\tvar \$".$fld['Field'].";\n";
				if($fld['Key']=='PRI')
				{
					$primary_field=$fld['Field'];
				}
				
			}
			$content.="\n";
			$content.="\t\tfunction __construct(){\n";
			$content.="\t\t\tparent::Model();\n";
			$content.="\t\t}\n\n";
			
			$content.="\t\tfunction get_all(){\n";
	        $content.="\t\t\t\$query = \$this->db->get('".$table_name."');\n";
	        $content.="\t\t\treturn \$query->result();\n";
    		$content.="\t\t}\n\n";
			
			$content.="\t\tfunction get_by_id(\$".$primary_field."){\n";
			$content.="\t\t\t\$this->db->where('".$primary_field."',\$".$primary_field.");\n";
			$content.="\t\t\t\$query = \$this->db->get('".$table_name."');\n";
	        $content.="\t\t\treturn \$query->row();\n";
    		$content.="\t\t}\n\n";

			$content.="\t\tfunction insert(\$data){\n";
			$content.="\t\t\t\$this->db->insert('".$table_name."',\$data);\n";
			$content.="\t\t}\n\n";
			
			$content.="\t\tfunction update(\$".$primary_field.",\$data){\n";
			$content.="\t\t\t\$this->db->where('".$primary_field."', \$".$primary_field.");\n";
			$content.="\t\t\t\$this->db->update('".$table_name."',\$data);\n";
			$content.="\t\t}\n\n";
			
			$content.="\t\tfunction delete(\$".$primary_field."){\n";
			$content.="\t\t\t\$this->db->where('".$primary_field."', $".$primary_field.");\n";
			$content.="\t\t\t\$this->db->delete('".$table_name."');\n";
			$content.="\t\t}\n\n";
			
			
			$content.="\t}\n";
			
			fwrite($file,$content);		  
			fclose($file);
			
		}
		
		mysql_close($conn);
		
		
	}
	
?>
</body>
</html>