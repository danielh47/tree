<?php
//a
    class Node
    {
        public $Name;
        public $IdNode;
        public $IdParent;
        
        public $Childs;
        
        public function __construct()
        {
            $IdNode = NULL;
            $Name = NULL;
            $IdParent = Null;
        }
        
        public function Move($idParent, $idChild)
        {
            if($idParent == $idChild)
                return;
            if($idParent == 'undefined')
            {
                    $sql="UPDATE `Node` SET `IdParents`=1  WHERE `Id`=$idChild";
                    if (!mysql_query($sql)) 
                    {
                        echo "ERROR:"; 
                        echo mysql_error();
                    } 
            }
            else
            {
                if($this->childInParent($idChild, $idParent) == true)
                {
                    echo 'Child in Parent';
                }
                else
                {
                    $sql="UPDATE `Node` SET `IdParents`= $idParent  WHERE `Id`=$idChild";
                    if (!mysql_query($sql)) 
                    {
                        echo "ERROR:"; 
                        echo mysql_error();
                    }                
                }
            }
        }
        
        public function Root()
        {
            $sql="SELECT * FROM Node WHERE Id=1";
            $data=mysql_fetch_array(mysql_query($sql));
            $this->Name = $data['Name'];
            $this->IdNode = $data['Id'];
            $this->IdParent = NUll;            
            echo "<li id=$this->IdNode> 
                    $this->IdNode.". " $this->Name 
                    <form action=index.php method=post>
                    <input type=hidden name=id value=$this->IdNode />
                    <input type=submit name=edit value=Edit />|
                    <input type=submit name=add value='Add Child' />
                    <input type=text name=name />
                    </form>
                    </li>";
            $sql="SELECT * FROM Node WHERE IdParents=1";
            $dataSQL=mysql_query($sql)or die(mysql_error());
            echo '<ul id="sortable" class='.$this->IdNode.'>';
    
            while($data=mysql_fetch_array($dataSQL))
            {
                $Childs = new Node();
                $Childs->makeChild($data['Id']); 
            }
            echo '</ul>';
        }
        
        private function makeChild($id)
        {
            $sql="SELECT * FROM Node WHERE Id=$id";
            $data=mysql_fetch_array(mysql_query($sql));
            $this->Name = $data['Name'];
            $this->IdNode = $data['Id'];
            $this->IdParent = NUll;            
            echo "<li id=$this->IdNode> 
                    $this->IdNode.". " $this->Name 
                    <form action=index.php method=post>
                    <input type=hidden name=id value=$this->IdNode />
                    <input type=submit name=edit value=Edit />|
                    <input type=submit name=delete value=Delete />|
                    <input type=submit name=add value='Add Child' />
                    <input type=text name=name />
                    </form>
                    </li>";
            $sql="SELECT * FROM Node WHERE IdParents=$id";
            $dataSQL=mysql_query($sql)or die(mysql_error());
            $i=0;            
            echo '<ul id="sortable" class='.$this->IdNode.'>';
    
            while($data=mysql_fetch_array($dataSQL))
            {
                $Childs[$i] = new Node();
                $Childs[$i]->makeChild($data['Id']); 
                $i=$i+1;
            }
            echo '</ul>';
        }
        
        private function childInParent($idParent, $idChild)
        {
            $sql="SELECT * FROM Node WHERE Id=$idChild";
            $data=mysql_fetch_array(mysql_query($sql));
            $tmpId = $data['IdParents'];
            while($tmpId != 1)
            {
                if($tmpId == $idParent)
                    return true;
                $sql="SELECT * FROM Node WHERE Id=$tmpId";
                $data=mysql_fetch_array(mysql_query($sql));
                $tmpId = $data['IdParents'];
            }
            return false;
        }
        
        static public function Enigne()
        {
            if(isset($_POST["edit"]))
            {
                if(isset($_POST["name"]))
                    if(NULL != $_POST["name"])
                        Node::Edit();
            }
            else if(isset($_POST["add"]))
            {
                if(isset($_POST["name"]))
                    if(NULL != $_POST["name"])
                        Node::Add();
            }
            else if(isset($_POST["delete"]))
            {
                Node::Delete($_POST["id"]);
            }
        }
        
        static private function Edit()
        {            
            $sql="UPDATE Node Set Name='$_POST[name]' WHERE Id=$_POST[id]";
            if (!mysql_query($sql)) 
            {
                echo "ERROR:"; 
                echo mysql_error();
            } 
        }
        
        static private function Add()
        {            
            $sql="INSERT INTO Node (Name, IdParents) VALUES ('$_POST[name]',$_POST[id])";
            if (!mysql_query($sql)) 
            {
                echo "ERROR:"; 
                echo mysql_error();
            } 
        }
        static private function Delete($idToDelete)
        {            
            $sql="SELECT * FROM Node WHERE IdParents=$idToDelete";
            $dataSQL=mysql_query($sql)or die(mysql_error());    
            while($data=mysql_fetch_array($dataSQL))
            {
                Node::Delete($data['Id']);
            }
            $sql="DELETE FROM Node WHERE Id=$idToDelete";
            if (!mysql_query($sql)) 
            {
                echo "ERROR:"; 
                echo mysql_error();
            } 
            
        }
    }
?>
