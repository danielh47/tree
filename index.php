<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        
        <link rel="stylesheet" type="text/css" href="style.css" />
	<link rel="stylesheet" href="ui/jquery.ui.all.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.7/jquery-ui.min.js"></script>
	<script src="ui/jquery.ui.core.js"></script> 
	<script src="ui/jquery.ui.widget.js"></script> 
	<script src="ui/jquery.ui.mouse.js"></script> 
	<script src="ui/jquery.ui.sortable.js"></script> 
        <script> 
	$(function() {
		$( "#sortable" ).sortable({
			stop: function(event, ui) { 
                                var idNewChild = $(ui.item).attr("id");
                                var second = ui.item.prev();
                                if (Number(second.attr("class")))
                                {
                                    var idNewParent = second.attr("class");
                                }
                                else if (Number(second.attr("id")))
                                {
                                    var idNewParent = second.attr("id");
                                }
                                document.location.href = "index.php?idNewChild="+idNewChild+"&idNewParent="+idNewParent+""
                        }
		});
		$( "#sortable" ).disableSelection();
	});
	</script> 
        <?php
            ob_start();
            require 'DataBase.php';
            require 'Node.php';
        ?>
    </head>
    <body>
        <?php
            connection();
            Node::Enigne();
        ?> 
        <div id="TREE">
            <ul> 
                <?php
                    $root = new Node();
                    $root->Root();  
                    if(isset($_GET['idNewParent']) && isset($_GET['idNewChild']))
                    {
                        $root->Move($_GET['idNewParent'], $_GET['idNewChild']);
                        header("Location: index.php");  
                    }
                    ob_end_flush();
                ?>
            </ul>
        </div>
    </body>
</html>
