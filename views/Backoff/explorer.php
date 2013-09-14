<?php debug($explorer); ?>


<?php $folder = $explorer['folder']; $back = $explorer['back']; $dir = $explorer['dir']; ?>
<?php $breadcrumb = str_replace('|',' / ',$folder);?>
<div class="row-fluid">
<h2>Explorateur de fichier</h2>
</div>
<div class="row-fluid top_explorer">
	<h5><?php echo $breadcrumb.' / '; ?></h5>

</div>
<div class="row-fluid">
<div class="span2 listExplorer">
<ul>
<?php 
foreach($explorer['file'] as $k => $v) {
	echo '<li class="list"><a href="'.BASE_URL.'/backoff/fileExplorer/'.$folder.'|'.$v.'">'.$v.'</a></li>';		
}
?>
</ul>
</div>
<div class="span10 window_explorer">
<li class="big_icone"><a href="<?php echo BASE_URL.'/backoff/fileExplorer/'.$back; ?>"><?php echo $this->img('design/img/Box_up.png', array('alt' => 'dossier parent', 'class'=> 'explorer_ico')).'<br>..' ?></a></li>	
<?php 
foreach($explorer['file'] as $k => $v):?>
<?php if(filetype($dir.'/'.$v)=='dir'){
		$icone = 'design/img/Folder.png';$alt='dossier';	
	}elseif(filetype($dir.'/'.$v)=='file'){
		if(preg_match('/(.jpg)|(.png)|(.gif)$/', $v)){
			$icone = 'design/img/Pictures.png';$alt='image';
		}else{
			$icone = 'design/img/Document.png';$alt='fichier';
		}
	} ?>
		<li class="big_icone"><a href="<?php echo BASE_URL.'/backoff/fileExplorer/'.$folder.'|'.$v; ?>"><?php echo $this->img($icone, array('alt' => $alt, 'class'=> 'explorer_ico')).'<br>'.$v; ?></a></li>		
<?php endforeach; ?>

</div>
</div>
<div class="row-fluid">
<?php 
$this->Form->create('backoff/fileExplorer/'.$folder, array('type' => 'FILE'));
$this->Form->input(array('type' => 'file', 'name' => 'new_file'));
$this->Form->end(array('type' => 'submit', 'value' => 'Ajouter', 'class' => 'btn btn-info submit'));

?>
</div>
