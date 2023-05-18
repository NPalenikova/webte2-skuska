function generatePDF() {
    const element = document.getElementById("manual");

    const config = { 
      filename: 'manual.pdf',
      margin: 10,
      html2canvas: { scale: 2 },
      jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };
  
    html2pdf().from(element).set(config).save();
  }