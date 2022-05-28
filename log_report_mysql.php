<!DOCTYPE html>
<html>
  <head>
    <title>Site Visits Report</title>
  </head>
  <body>
      <h1>Site Visits Report</h1>
      <table border = '2'>
        <tr>
          <th>Nª</th>
          <th>Visitor</th>
          <th>Total Visits</th>
        </tr>

        <?php
            $user = "david";
            $password = "123@David";
            $database = "bbdd01";

            try {

                $db = new PDO("mysql:host=localhost;dbname=$database", $user, $password);

                $siteVisitsMap = 'siteStats';

                $i = 1;
                foreach($db->query("SELECT dir_ip, visits FROM visits_david") as $row) {
                    echo "<tr>";
                      echo "<td align = 'left'>"   . $i . "."     . "</td>";
                      echo "<td align = 'left'>"   . $row['dir_ip']     . "</td>";
                      echo "<td align = 'right'>"  . $row['visits'] . "</td>";
                    echo "</tr>";

                    $i++;
                }

            } catch (Exception $e) {
                echo $e->getMessage();
            }

        ?>

      </table>
  </body>

</html>