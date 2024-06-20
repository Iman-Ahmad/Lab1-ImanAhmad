<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $borrowerIDs = $_POST['borrowerID'];
    $taxIDs = $_POST['taxID'];
    $individualOrLegals = isset($_POST['individualOrLegal']) ? $_POST['individualOrLegal'] : [];
    $addresses = $_POST['address'];
    $amounts = $_POST['amount'];
    $conditions = $_POST['conditions'];
    $legalNotes = $_POST['legalNotes'];
    $contractLists = $_POST['contractList'];

    for ($i = 0; $i < count($taxIDs); $i++) {
        $borrowerID = $borrowerIDs[$i];
        $taxID = $taxIDs[$i];
        $individualOrLegal = isset($individualOrLegals[$i]) ? 1 : 0;
        $address = $addresses[$i];
        $amount = $amounts[$i];
        $condition = $conditions[$i];
        $legalNote = $legalNotes[$i];
        $contractList = $contractLists[$i];

        if ($borrowerID) {
            // Update existing row
            $sql = "UPDATE borrowers 
                    SET TaxID='$taxID', IndividualOrLegal='$individualOrLegal', Address='$address', Amount='$amount', Conditions='$condition', LegalNotes='$legalNote', ContractList='$contractList' 
                    WHERE BorrowerID='$borrowerID'";
        } else {
            // Insert new row
            $sql = "INSERT INTO borrowers (TaxID, IndividualOrLegal, Address, Amount, Conditions, LegalNotes, ContractList) 
                    VALUES ('$taxID', '$individualOrLegal', '$address', '$amount', '$condition', '$legalNote', '$contractList')";
        }

        if (!$conn->query($sql)) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Fetch and display data
$sql = "SELECT * FROM borrowers";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td><input type='hidden' name='borrowerID[]' value='{$row['BorrowerID']}' />{$row['BorrowerID']}</td>
                <td><input type='text' name='taxID[]' value='{$row['TaxID']}' /></td>
                <td><input type='checkbox' name='individualOrLegal[]' " . ($row['IndividualOrLegal'] ? "checked" : "") . " /></td>
                <td><input type='text' name='address[]' value='{$row['Address']}' /></td>
                <td><input type='number' step='0.01' name='amount[]' value='{$row['Amount']}' /></td>
                <td><input type='text' name='conditions[]' value='{$row['Conditions']}' /></td>
                <td><input type='text' name='legalNotes[]' value='{$row['LegalNotes']}' /></td>
                <td><input type='text' name='contractList[]' value='{$row['ContractList']}' /></td>
                <td><button type='button' onclick='deleteRow(this)'>Delete</button></td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='9'>No records found</td></tr>";
}

$conn->close();
?>
