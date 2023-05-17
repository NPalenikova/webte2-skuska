function generateCSV(){
    const table = document.getElementById("tab1");
    const data = [];

    const headerRow = table.getElementsByTagName("thead")[0].getElementsByTagName("tr")[0];
    const headers = Array.from(headerRow.getElementsByTagName("th")).map(header => header.textContent);
    data.push(headers); 
    
    const rows = table.getElementsByTagName("tbody")[0].getElementsByTagName("tr");
    for (const row of rows) {
        const rowData = [];

        const cells = row.getElementsByTagName("td");
        for (const cell of cells) {
            rowData.push(cell.textContent);
        }
  
        data.push(rowData);
    }

    const csvContent = data.map(row => row.join(",")).join("\n");

    const blob = new Blob([csvContent], { type: "text/csv;charset=utf-8" });

    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = "table_data.csv";
    link.click();
}