<?php
$find = array('\\',  "'" );
$repl = array('\\\\',"\'");
$encodedTitle = str_replace($find,$repl,$this->lang['Sidebar-title']);
$self = str_replace('/','\/',$_SERVER['PHP_SELF']);
?>
<!doctype html>
<html lang="<?php echo $this->scriptLanguage; ?>" class="lang-<?php echo $this->scriptLanguage; ?>">
<head>
	<title><?php echo $this->lang['Title']; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta content="Mike Poltyn" name="author" />
	<link rel="stylesheet" type="text/css" href="gui/monobook/main.css" />
	<link rel="stylesheet" type="text/css" href="gui/monobook/main-<?php echo $this->direction; ?>.css" />
	<link rel="icon" type="image/png" href="gui/monobook/favicon.png" />
	<!--[if lt IE 5.5000]><style type="text/css">@import "gui/monobook/fixes/IE50Fixes.css";</style><![endif]-->
	<!--[if IE 5.5000]><style type="text/css">@import "gui/monobook/fixes/IE55Fixes.css";</style><![endif]-->
	<!--[if IE 6]><style type="text/css">@import "gui/monobook/fixes/IE60Fixes.css";</style><![endif]-->
	<!--[if IE 7]><style type="text/css">@import "gui/monobook/fixes/IE70Fixes.css";</style><![endif]-->
</head>

<body style="direction: <?php echo $this->direction; ?>;" class="mediawiki ns--1 <?php echo $this->direction; ?>"> 
<div id="dhtmltooltip"></div>
<div id="globalWrapper">
	<div id="column-content">
		<div id="content"><a id="top"></a>
<?php if ($veryImportantMessage) : ?> 
			<div id="veryImportantMessage"><?php echo $this->veryImportantMessage; ?></div>
<?php endif; ?>
			<h1 class="firstHeading"><?php echo $this->lang['Title']; ?></h1>
			<div id="bodyContent">
				<h2><?php echo $this->lang['Input-title']; ?></h2>
				<p>
					<?php printf($this->lang['Input-text'], implode(', ',$this->availableParsers)); ?>
				</p>
				<form action="redirect.php" method="get">
					<p>
					<?php for ($i=0;$i<6;$i++) : ?>
					<input name="input[]" value="<?php $this->eprint($this->input[$i]); ?>" type="text" />
					<?php endfor; ?></p>
					<div id="parsersContent">
					<h4><?php echo $this->lang['Parsers'];?></h4>
					<?php foreach ($this->selects['parsers'] as $parser => $select) : ?>
					<label for="<?php echo $parser;?>"><?php echo $parser;?></label>
					<?php echo $select; ?><br/>
					<?php endforeach; ?></div>
					<table><tbody>
					<tr>
						<td><label for="citelang"><?php echo $this->lang['Template-lang'];?></label></td>
						<td><?php echo $this->selects['output']; ?></td>
					</tr>
					<?php foreach ($this->availableSettings as $setting) : ?>
					<tr>
						<td><label for="<?php echo $setting; ?>"><?php $this->eprint($this->lang['Option-'.$setting]); ?></label></td>
						<td><input name="s[<?php echo $setting; ?>]" id="<?php echo $setting; ?>" type="checkbox"<?php if ($this->settings[$setting] == true) echo ' checked="checked"'; ?> /></td>
					</tr>
					<?php endforeach; ?>
					<tr>
						<td><label for="template"><?php echo $this->lang['Skins'];?></label></td>
						<td><?php echo $this->selects['skins']; ?></td>
					</tr>
					<tr>
						<td/>
						<td><input type="submit" value="<?php $this->eprint($this->lang['Send']); ?>" /></td>
					</tr>
					</tbody></table>
				</form>
<?php           if (count($this->input) || (count($this->inputMessages) && count($this->bookshelf))) : ?>
				<h2><?php echo $this->lang['Output-title']; ?></h2>
<?php			if (count($this->bookshelf)) : ?>
				<textarea style="width:100%;" rows="16" cols="30" id="output"><?php
				foreach ($this->bookshelf as $book) :
					echo $this->eprint($book)."\n";
				endforeach; ?></textarea>
<?php			endif; if (count($this->inputMessages)) : ?>
				<span style="font-size:90%;"><ul><?php
				foreach ($this->inputMessages as $inputMessage) : ?>
					<li><?php $this->eprint($inputMessage); ?></li>
<?php				endforeach; ?></ul></span>
<?php			endif; if (count($this->bookshelf)) : ?>
				<h3><?php echo $this->lang['Sources-title']; ?></h3>
				<p><?php echo $this->lang['Sources-text']; ?></p>
				<ul>
				<?php
				foreach ($this->sources as $source) : ?>
					<li><a href="<?php $this->eprint($source[0]); ?>" target="_blank"><?php $this->eprint($source[1]); ?></a> (<?php $this->eprint($source[2]['parser'].' '.$source[2]['data']); ?>)</li>
<?php			endforeach; ?>
				</ul>
<?php			endif;
				endif;
				if (count($this->errors)) : ?>
				<h3><?php echo $this->lang['Errors-title']; ?></h3>
				<ul><?php
				foreach ($this->errors as $error) :
					echo '<li>'.$error."</li>\n";
				endforeach; ?></ul>
<?php           endif; ?>
<?php           if (strlen($this->debug)) : ?>
				<h2>Debug</h2>
				<pre><?php $this->eprint($this->debug); ?></pre>
<?php           endif; ?>
			</div>
		</div>
	</div>
	<div id="logo">
		<img src="gui/monobook/wiki.png" alt="Logo" />
	</div>
	<div class="portlet">
		<h5><?php echo $this->lang['Tools']; ?></h5>
		<div class="pBody">
			<ul id="tools-portlet">
				<?php $url = $_SERVER['SCRIPT_NAME']; ?>
				<li><a href="<?php echo $url.((count($this->query))?'?'. htmlentities (http_build_query($this->query)):'');?>"><?php echo $this->lang['Save-it'];?></a></li>
			</ul>
		</div>
		<h5><?php echo $this->lang['Other-languages']; ?></h5>
		<div class="pBody">
			<ul>
				<?php 
				foreach ($this->availableLanguages as $lang) :
					$this->query['scriptlang'] = $lang;
					echo '<li><a href="'. $url .((count($this->query))?'?'.htmlentities(http_build_query($this->query)):'').'">'.$this->languages[$lang].'</a></li>';
				endforeach;
				 ?>
			</ul>
		</div>
	</div>
	<div class="visualClear"/>
	<div id="footer">
		<div id="f-poweredbyico"><a href="/"><img src="http://upload.wikimedia.org/wikipedia/commons/0/0f/Wikimedia-toolserver-button.png" alt="Powered by the Toolserver"/></a></div>
		<div id="f-copyrightico"><a href="/~holek/"><img src="/~holek/holekproject.png" alt="A Holek project"/></a></div>
		<ul>
			<li><a href="https://github.com/Holek/cite-gen">Source of the generator</a>.</li>
			<li>A series of tools by: <a href="http://mike.poltyn.com/">Mike "Hołek" Połtyn</a></li>
			<li>Wiki: <a href="http://pl.wikipedia.org/wiki/Dyskusja_wikipedysty:Holek">user talk</a></li>
		</ul>
	</div>
</div>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script type="text/javascript">
var tiptext = '<?php echo str_replace($find,$repl,$this->lang['Output-select-disclaimer']); ?>';
/************************
     Sidebar panels
************************/
var sidebar = '';
if( window.sidebar && window.sidebar.addPanel ) {
  sidebar = '<a href="javascript:window.sidebar.addPanel( \'<?php echo $encodedTitle; ?>\', \'http:\/\/toolserver.org<?php echo $self; ?>?template=sidebar\', \'\' );"><?php echo str_replace($find,$repl,$this->lang['Sidebar-add-Firefox']); ?><\/a>' ;
} else if( window.opera && window.print ) {
  sidebar = '<a title="<?php echo $encodedTitle; ?>" rel="sidebar" href="http:\/\/toolserver.org<?php echo $self; ?>?template=sidebar"><?php echo str_replace($find,$repl,$this->lang['Sidebar-add-Opera']); ?><\/a>' ;
} else if( window.ActiveXObject && navigator.platform.indexOf('Mac') + 1 && !navigator.__ice_version && ( !window.ScriptEngine || ScriptEngine().indexOf('InScript') == -1 ) ) {
  sidebar = '<a href="http:\/\/toolserver.org<?php echo $self; ?>?template=sidebar" onclick="window.alert(\'<?php echo str_replace($find,$repl,$this->lang['Sidebar-add-IE-Mac-details']);?>\');" target="_blank"><?php echo str_replace($find,$repl,$this->lang['Sidebar-add-IE-Mac']); ?><\/a>' ;
}

if (sidebar != '') {
  $('#tools-portlet').append($('<li/>').html(sidebar));
}

offsetxpoint=20 //Customize x offset of tooltip
offsetypoint=20 //Customize y offset of tooltip
ie=document.all
ns6=document.getElementById && !document.all
enabletip=false
if (ie||ns6)
tipobj=document.all? document.all["dhtmltooltip"] : document.getElementById? document.getElementById("dhtmltooltip") : ""


$('#citelang').hover(function () {
ddrivetip(tiptext,null, 300);
}, function () {
hideddrivetip();
})

$('input:checkbox').change(function () {
  var output = document.getElementById('output');
  if ( output )
  switch (this.id)
  {
    case 'add-list':
      if (document.getElementById('add-list').checked==false) {
        if (document.getElementById('add-references').checked == true) {
          output.value = output.value.replace(/\* <ref/g, '<ref');
        }
        else {
          output.value = output.value.replace(/\* \{\{/g, '{{');
        }
      }
      else {
        if (document.getElementById('add-references').checked == true) {
          output.value = output.value.replace(/<ref/g, '* <ref');
        }
        else {
          output.value = output.value.replace(/\{\{/g, '* {{');
        }
      }
    break;
    case 'add-references':
      if (document.getElementById('add-references').checked==false) {
        outputText = output.value.replace(/<ref(| name="(.*?)")>/g, '');
        outputText = outputText.replace(/<\/ref>/g, '');
        output.value = outputText;
      }
      else {
        outputText = output.value.replace(/\{\{/g, '<ref>{{');
        outputText = outputText.replace(/\}\}/g, '}}</ref>');
        output.value = outputText;
      }
      break;
    case 'append-newlines':
      if (document.getElementById('append-newlines').checked==false) {
        output.value = output.value.replace(/\n\| /g, ' | ');
      }
      else {
        output.value = output.value.replace(/ \| /g, "\n| ");
      }
      break;
    default:
    break;
  }
});

/***********************************************
* Cool DHTML tooltip script- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/
function ietruebody(){return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body;}

function ddrivetip(thetext, thecolor, thewidth){
if (ns6||ie){
if (typeof thewidth!="undefined") tipobj.style.width=thewidth+"px"
if (typeof thecolor!="undefined" && thecolor!="") tipobj.style.backgroundColor=thecolor
tipobj.innerHTML=thetext
enabletip=true
return false
}
}

function positiontip(e){
if (enabletip){
var curX=(ns6)?e.pageX : event.clientX+ietruebody().scrollLeft;
var curY=(ns6)?e.pageY : event.clientY+ietruebody().scrollTop;
//Find out how close the mouse is to the corner of the window
var rightedge=ie&&!window.opera? ietruebody().clientWidth-event.clientX-offsetxpoint : window.innerWidth-e.clientX-offsetxpoint-20
var bottomedge=ie&&!window.opera? ietruebody().clientHeight-event.clientY-offsetypoint : window.innerHeight-e.clientY-offsetypoint-20

var leftedge=(offsetxpoint<0)? offsetxpoint*(-1) : -1000

//if the horizontal distance isn't enough to accomodate the width of the context menu
if (rightedge<tipobj.offsetWidth)
//move the horizontal position of the menu to the left by it's width
tipobj.style.left=ie? ietruebody().scrollLeft+event.clientX-tipobj.offsetWidth+"px" : window.pageXOffset+e.clientX-tipobj.offsetWidth+"px"
else if (curX<leftedge)
tipobj.style.left="5px"
else
//position the horizontal position of the menu where the mouse is positioned
tipobj.style.left=curX+offsetxpoint+"px"

//same concept with the vertical position
if (bottomedge<tipobj.offsetHeight)
tipobj.style.top=ie? ietruebody().scrollTop+event.clientY-tipobj.offsetHeight-offsetypoint+"px" : window.pageYOffset+e.clientY-tipobj.offsetHeight-offsetypoint+"px"
else
tipobj.style.top=curY+offsetypoint+"px"
tipobj.style.visibility="visible"
}
}

function hideddrivetip(){
if (ns6||ie){
enabletip=false;
tipobj.style.visibility="hidden";
tipobj.style.left="-1000px";
tipobj.style.backgroundColor='';
tipobj.style.width='';
}
}

document.onmousemove=positiontip;

// submitting with no parsers selected when there are ISBN in the input fields
$('form').submit(function () {
  var isbns = false
    , texts = $('input[type=text]')
    , tl = texts.length
    , sel = $(':selected', '#ISBN')
    ;
  if (sel.length == 0) {
    for (var i = 0; i < tl && !isbns; i++) {
      var val = texts[i].value.replace('-','').replace('x','X');
      if (val.length == 10) {
        isbns = (
          (((Number(val[0]))    //  (1 * x1
          +(2*Number(val[1])) // + 2 * x2
          +(3*Number(val[2])) // + 3 * x3
          +(4*Number(val[3])) // + ...
          +(5*Number(val[4]))
          +(6*Number(val[5]))
          +(7*Number(val[6]))
          +(8*Number(val[7])) // + ...
          +(9*Number(val[8])) // + 9 * x9)
            )%11) ==                // mod 11 == x10
            ((val[9]=='X')?10:Number(val[9]))
          );
      } else if ( val.length == 13 ) {
        isbns = (((10-           // (10 -
          ((Number(val[0]))      //  (1 * x1
          +(3*Number(val[1]))  // + 3 * x2
          +(  Number(val[2]))  // + 1 * x3
          +(3*Number(val[3]))  // + ...
          +(  Number(val[4]))
          +(3*Number(val[5]))
          +(  Number(val[6]))
          +(3*Number(val[7]))  // + ...
          +(  Number(val[8]))  // + 1 * x9
          +(3*Number(val[9]))  // + 3 * x10
          +(  Number(val[10])) // + 1 * x11
          +(3*Number(val[11])) // + 3 * x12)
          )%10))%10               // mod 10) == x13 // 0 replaces 10
          == Number(val[12]));
      }
    }
    // select all if none is checked and ISBNs are present
    if ( isbns ) {
      $('option', '#ISBN').each(function(i) {
        this.selected = true;
      })
    }
  }
  return true; // no matter what, submit
});
</script>
</body>
</html>
