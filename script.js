function addRow() {
    const table = document.getElementById('borrowersTable').getElementsByTagName('tbody')[0];
    const newRow = table.insertRow();

    // Insert cells for new row
    newRow.innerHTML = `
        <td><input type='hidden' name='borrowerID[]' value='' />Auto</td>
        <td><input type="text" name="taxID[]" /></td>
        <td><input type="checkbox" name="individualOrLegal[]" /></td>
        <td><input type="text" name="address[]" /></td>
        <td><input type="number" step="0.01" name="amount[]" /></td>
        <td><input type="text" name="conditions[]" /></td>
        <td><input type="text" name="legalNotes[]" /></td>
        <td><input type="text" name="contractList[]" /></td>
        <td><button type="button" onclick="deleteRow(this)">Delete</button></td>
    `;
}

function deleteRow(button) {
    const row = button.parentElement.parentElement;
    row.remove();
}

function goHome() {
    window.location.href = '/';
}
