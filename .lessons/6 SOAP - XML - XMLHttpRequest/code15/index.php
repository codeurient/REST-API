<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>TCMB Kurları</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    table { border-collapse: collapse; width: 100%; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
    th { background: #eee; }
  </style>
</head>
<body>
  <h2>TCMB Günlük Döviz Kurları</h2>
  <table id="kurTable">
    <thead>
      <tr>
        <th>Kod</th>
        <th>Ad</th>
        <th>Alış</th>
        <th>Satış</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>

<script>
    fetch("proxy.php")
      .then(res => res.text())
      .then(data => {
        const parser = new DOMParser();
        const xml = parser.parseFromString(data, "application/xml");

        const currencies = xml.getElementsByTagName("Currency");
        const tbody = document.querySelector("#kurTable tbody");

        for (let cur of currencies) {
          const code = cur.getAttribute("CurrencyCode");
          const name = cur.getElementsByTagName("Isim")[0]?.textContent || "";
          const forexBuy = cur.getElementsByTagName("ForexBuying")[0]?.textContent || "-";
          const forexSell = cur.getElementsByTagName("ForexSelling")[0]?.textContent || "-";

          const row = document.createElement("tr");
          row.innerHTML = `
            <td>${code}</td>
            <td>${name}</td>
            <td>${forexBuy}</td>
            <td>${forexSell}</td>
          `;
          tbody.appendChild(row);
        }
      })
      .catch(err => console.error("Xəta:", err));
</script>

</body>
</html>
