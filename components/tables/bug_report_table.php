<table class="table datatable">
    <thead>
        <tr>
			<th width="60">Id</th>
            <th width="150">Name</th>
            <th width="150">Mail</th>
            <th>Bug</th>
			<th width="90">Creation Date</th>
			<th width="90">Last Operation</th>
            <th width="100">State</th>
            <th width="150">Actions</th>
        </tr>
    </thead>
    <tbody id="bug_report_table_body">
    <?php
        if(isset($bugs) && $bugs["result"] == true) {
            foreach ($bugs["content"] as $value) {
                echo "<tr id=\"trow_" . $value["Id"] . "\">";
				echo "<td>" . $value["Id"] . "</td>";
				echo "<td>" . $value["Name"] . "</td>";
				echo "<td>" . $value["Mail"] . "</td>";
				echo "<td>" . $value["Bug"] . "</td>";
				echo "<td>" . $value["CreationDate"] . "</td>";
				echo "<td>" . $value["LastOperation"] . "</td>";
                $status = "";
				switch($value["Status"]) {
					case 'Resolved':
						$status .= "<span class=\"label label-success\" style=\"background-color:red;\"><i class='fa fa-check'></i> " . $value["Status"] . "</span> ";
						break;
					case 'Assigned':
						$status .= "<span class=\"label label-success\" style=\"background-color:orange;\"><i class='fa fa-wrench'></i> " . $value["Status"] . "</span> ";
						break;
					case 'Open':
						$status .= "<span class=\"label label-success\" style=\"background-color:yellow;\"><i class='fa fa-question'></i> " . $value["Status"] . "</span> ";
						break;
					case 'New':
						$status .= "<span class=\"label label-success\" style=\"background-color:green;\"><i class='fa fa-phone'></i> " . $value["Status"] . "</span> ";
						break;
					default:
						$status .= "<span class=\"label label-primary\" style=\"background-color:grey;\">" . $value["Status"] . "</span> ";
						break;
				}
				echo "<td class=\"status\">" . $status . "</td>";
                echo "<td>";
				if($value["Status"] != "Resolved") {
					echo "<button class=\"btn btn-default btn-rounded btn-sm\" style=\"background-color:orange;\" onClick=\"change_status(" . $value["Id"] . ", 4);\"><i class=\"fa fa-check\"></i> To Resolved</button>
						  <button class=\"btn btn-default btn-rounded btn-sm\" style=\"background-color:yellow;\" onClick=\"change_status(" . $value["Id"] . ", 3);\"><i class=\"fa fa-wrench\"></i> To Assigned</button>
						  <button class=\"btn btn-default btn-rounded btn-sm\" style=\"background-color:green;\"  onClick=\"change_status(" . $value["Id"] . ", 2);\"><i class=\"fa fa-question\"></i> To Open</button>";
				} else {
					echo "The bug is resolved.";
				}
				echo "</td>";
                echo "</tr>";
            }
        } else {
            echo $bugs["msg"];
        }
    ?>
    </tbody>
</table>