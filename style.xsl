<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" 
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

  <xsl:template match="/">
    <html>
      <body>
        <h2>Şəxsin məlumatı</h2>
        <ul>
          <li>Ad: <xsl:value-of select="shexs/ad"/></li>
          <li>Soyad: <xsl:value-of select="shexs/soyad"/></li>
          <li>Yaş: <xsl:value-of select="shexs/yas"/></li>
          <li>Şəhər: <xsl:value-of select="shexs/seher"/></li>
        </ul>
      </body>
    </html>
  </xsl:template>
</xsl:stylesheet>
