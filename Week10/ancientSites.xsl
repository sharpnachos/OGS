<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0"
xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html"/>
<xsl:template match="/">
  <html>
    <head>
      <meta charset="utf-8"></meta>
      <title>Ancient Sites</title>
      <link rel="stylesheet" type="text/css" href="week10.css"></link>
    </head>
    <body>
      <header>
        <h1>Historical Places and Buildings</h1>
        <h2>Irish old stuff.</h2>
      </header>
      <table summary="section for old stuff">
        <caption>Old Stuff</caption>
        <thead>
          <tr>
            <th>Site</th>
            <th>Year Built</th>
            <th>Dynasty</th>
            <th>Years Extant</th>
            <th>Overview</th>
            <th>Images</th>
            <th>Example</th>
            <th>Description</th>
          </tr>
        </thead>
        <tbody>
          <xsl:apply-templates select="ancient_sites/site">
            <xsl:sort select="location" order="ascending" data-type="string" />
          </xsl:apply-templates>
        </tbody>
      </table>
      <table summary="New stuff">
        <caption>Newer Stuff</caption>
        <thead>
          <tr>
            <th>Site</th>
            <th>Year Built</th>
            <th>Dynasty</th>
            <th>Years Extant</th>
            <th>Overview</th>
            <th>Images</th>
            <th>Example</th>
            <th>Description</th>
          </tr>
        </thead>
        <tbody>
          <xsl:apply-templates select="ancient_sites/site[./history/year &lt; 1571]">
            <xsl:sort select="year" order="descending" data-type="number" />
          </xsl:apply-templates>
        </tbody>
      </table>
    </body>
  </html>
</xsl:template>
<xsl:template match="site">
  <tr>
    <xsl:apply-templates select="name[@language='english']"/>
    <xsl:apply-templates select="history"/>
    <xsl:apply-templates select="links/overview[@type='general']"/>
    <xsl:apply-templates select="images"/>
    <xsl:apply-templates select="notes/note[@type='intro']"/>
  </tr>
</xsl:template>
<xsl:template match="name[@language='english']">
  <td>
    <xsl:value-of select="."/>
  </td>
</xsl:template>
<xsl:template match="history">
  <td>
    <xsl:value-of select="year"/>
    <xsl:text>&#160;</xsl:text>
    <xsl:value-of select="year/@era"/>
  </td>
  <td>
    <xsl:value-of select="./dynasty"/>
  </td>
  <td>
    <xsl:choose>
      <xsl:when test="year[@range='end']">
        <xsl:value-of select="year[@range='start'] - year[@range='end']"/>
      </xsl:when>
      <xsl:otherwise>
       <xsl:value-of select="year[@range='start'] + 2017"/>
      </xsl:otherwise>
    </xsl:choose>
  </td>
</xsl:template>
<xsl:template match="dimensions">
  <td>
    approx. <xsl:value-of select="ceiling(./width * ./width)"/> m<sup>2</sup>
  </td>
  <td>
    avg. height <xsl:value-of select="sum(./height) div count(./height)"/>
  </td>
</xsl:template>
<xsl:template match="links/overview[@type='general']">
  <td>
    <a>
      <xsl:attribute name="href">
        <xsl:value-of select="./@url"/>
      </xsl:attribute>
      <xsl:value-of select="translate(., 'w', 'W')"/>
    </a>
  </td>
</xsl:template>
<xsl:template match="images">
  <td><xsl:value-of select="count(./image)"/></td>
  <td>
    <a>
      <xsl:attribute name="href">
        <xsl:value-of select="image[@type='jpg'][position() = last()]/@url"/>
      </xsl:attribute>
      <img>
        <xsl:attribute name="src">
          <xsl:value-of select="image[@type='jpg' and @size='thumb']/@url"/>
        </xsl:attribute>
      </img>
    </a>
  </td>
</xsl:template>
<xsl:template match="notes/note[@type='intro']">
  <td>
    <xsl:value-of select="substring(.,1,75)"/>
    ...
  </td>
</xsl:template>
</xsl:stylesheet>