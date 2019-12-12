!TCL=5901, Copyleft © 2010 Unamemte 
!TITLE=PHP Devta
!SORT=N
!CHARSET=ANSI

!TEXT=Signos <> ^
<>
!
!TEXT=Llaves { } ^
 {
	
 }
!
!TEXT=If ^
if(){
	\^
}

!
!TEXT=If else ^
if(){
	\^
}else{

}

!

!TEXT=If else ^
if(){
	\^
}elseif(){
	
}else{

}

!
!TEXT=switch ^
switch(\^) {
	case '':
	{

		break;	
	}

	case '':
	{

		break;	
	}

	default:
	{

		break;	
	}			
}

!
!TEXT=case ^
	case '':
	{
		\^
		break;	
	}

!
!TEXT=class ^
class extends {
	\^
}
!

!TEXT=function ^
function (){
	\^
	return();	
}
!

!TEXT=Anchor - Image ^
<A HREF="http://?"><IMG SRC="?.GIF" ALT="?" BORDER=0>\^</A>
!
!TEXT=Anchor - Text ^
<A HREF="http://?">\^</A>
!
!TEXT=Applet ^
<APPLET CODE="?.class" LANGUAGE=JAVASCRIPT>
\\^
</APPLET>

!
!TEXT=Block - Address ^
<ADDRESS>
\\^
</ADDRESS>

!
!TEXT=Block - Break Line
<BR>
!
!TEXT=Block - Center ^
<CENTER>
\\^
</CENTER>

!
!TEXT=Block - Citation ^
<CITE>\^</CITE>
!
!TEXT=Block - Code Extract ^
<CODE>\^</CODE>
!
!TEXT=Block - Definition ^
<DFN>\^</DFN>
!
!TEXT=Block - Definition List
<DL>
	<DT>\^<DD> ?
	<DT>?<DD> ?
</DL>

!
!TEXT=Block - Division ^
<DIV ALIGN="left">
\\^
</DIV>

!
!TEXT=Block - Horizontal Rule
<HR ALIGN="center" WIDTH="100%">

!
!TEXT=Block - Ordered List
<OL>
	<LI> \^
	<LI> ?
</OL>

!
!TEXT=Block - Paragraph
<P ALIGN="left">
!
!TEXT=Block - Preformatted ^
<PRE>
\\^
</PRE>

!
!TEXT=Block - Quotation ^
<BLOCKQUOTE>
\\^
</BLOCKQUOTE>

!
!TEXT=Block - Sample Output ^
<SAMPLE>\^</SAMPLE>
!
!TEXT=Block - Unordered List
<UL>
	<LI> ?
	<LI> ?
</UL>

!
!TEXT=Color - Aqua
"#00FFFF"
!
!TEXT=Color - Black
"#000000"
!
!TEXT=Color - Blue
"#0000FF"
!
!TEXT=Color - Fuschia
"#FF00FF"
!
!TEXT=Color - Gray
"#808080"
!
!TEXT=Color - Green
"#008000"
!
!TEXT=Color - Lime
"#00FF00"
!
!TEXT=Color - Maroon
"#800000"
!
!TEXT=Color - Navy
"#000080"
!
!TEXT=Color - Olive
"#808000"
!
!TEXT=Color - Purple
"#800080"
!
!TEXT=Color - Red
"#FF0000"
!
!TEXT=Color - Silver
"#C0C0C0"
!
!TEXT=Color - Teal
"#008080"
!
!TEXT=Color - White
"#FFFFFF"
!
!TEXT=Color - Yellow
"#FFFF00"
!
!TEXT=Comment ^
<!-- \^ -->
!
!TEXT=Font - Big ^
<BIG>\^</BIG>
!
!TEXT=Font - Bold ^
<B>\^</B>
!
!TEXT=Font - Emphasis ^
<EM>\^</EM>
!
!TEXT=Font - Italic ^
<I>\^</I>
!
!TEXT=Font - Small ^
<SMALL>\^</SMALL>
!
!TEXT=Font - Strong Emphasis ^
<STRONG>\^</STRONG>
!
!TEXT=Font - Subscript ^
<SUB>\^</SUB>
!
!TEXT=Font - Superscript ^
<SUP>\^</SUP>
!
!TEXT=Font - Underline ^
<U>\^</U>
!
!TEXT=Font 1 ^
<FONT SIZE="1">\^</FONT>
!
!TEXT=Font 2 ^
<FONT SIZE="2">\^</FONT>
!
!TEXT=Font 3 ^
<FONT SIZE="3">\^</FONT>
!
!TEXT=Font 4 ^
<FONT SIZE="4">\^</FONT>
!
!TEXT=Font 5 ^
<FONT SIZE="5">\^</FONT>
!
!TEXT=Font 6 ^
<FONT SIZE="6">\^</FONT>
!
!TEXT=Font 7 ^
<FONT SIZE="7">\^</FONT>
!
!TEXT=Heading 1 ^
<H1>\^</H1>
!
!TEXT=Heading 2 ^
<H2>\^</H2>
!
!TEXT=Heading 3 ^
<H3>\^</H3>
!
!TEXT=Heading 4 ^
<H4>\^</H4>
!
!TEXT=Heading 5 ^
<H5>\^</H5>
!
!TEXT=Heading 6 ^
<H6>\^</H6>
!
!TEXT=Table
<TABLE ALIGN="left" BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH="100%">
<TR ALIGN="left" VALIGN="middle">
	<TH>\^</TH>
	<TH>?</TH>
</TR>
<TR ALIGN="left" VALIGN="middle">
	<TD> ? </TD>
	<TD> ? </TD>
</TR>
</TABLE>

!
!TEXT=Table Data Cell ^
<TD>\^</TD>
!
!TEXT=Table Heading Cell ^
<TH>\^</TH>
!
!TEXT=Table Row ^
<TR>\^</TR>
!
