function PrintDiv() {
    console.log(document.head.innerHTML);
    console.log(document.body.innerHTML);
    var popupWin = window.open('', '_blank', 'width=300,height=300');
    popupWin.document.open();
    popupWin.document.write('<html><head>' + document.head.innerHTML + '</head><body onload="window.print()">' + document.getElementById('viewer').innerHTML + '</body></html>');
    popupWin.document.close();
}