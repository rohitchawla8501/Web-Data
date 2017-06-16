<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/">
<html>
<body>
<h2>SHOPPING SEARCH</h2>
<table border="2">
    <tr bgcolor="blue">
      <th>Product ID</th>
	  <th>Name</th>
      <th>Minprice</th>
      <th>Description</th>
	  <th>Source URL</th>
	</tr>
	 <xsl:for-each select="/GeneralSearchResponse/categories/category/items/product">
	<tr>
	<td><xsl:value-of select="@id"/></td>
	<td><xsl:value-of select="name"/></td>
	<td><xsl:value-of select="minPrice"/></td>
	<td><xsl:value-of select="fullDescription"/></td>
	<td><xsl:value-of select="images/image/sourceURL"/></td>
    
	</tr>
	</xsl:for-each>
  </table>
  </body>
  </html>
</xsl:template>

</xsl:stylesheet>