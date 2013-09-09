<?php debug($explorer); ?>


<?php $folder = $explorer['folder']; $back = $explorer['back']; ?>
<?php $breadcrumb = str_replace('|',' / ',$folder);?>
<div class="row-fluid">
<h2>Explorateur de fichier</h2>
<a href="<?php echo BASE_URL.'/backoff/fileExplorer/'.$back; ?>">Retour</a>
</div>
<div class="row-fluid">
<div class="span4">
<h5><?php echo $breadcrumb.' / '; ?></h5>
<ul>
<?php 
foreach($explorer['file'] as $k => $v) {
	echo '<li><a href="'.BASE_URL.'/backoff/fileExplorer/'.$folder.'|'.$v.'">'.$v.'</a></li>';		
}
?>
</ul>
</div>
<div class="span8">
<?php 
foreach($explorer['file'] as $k => $v) {
	echo '<li><a href="'.BASE_URL.'/backoff/fileExplorer/'.$folder.'|'.$v.'">'.$v.'</a></li>';		
}
?>
</div>
</div>
<div class="row-fluid">
<?php 
$this->Form->create('backoff/fileExplorer/'.$folder, array('type' => 'FILE'));
$this->Form->input(array('type' => 'file', 'name' => 'new_file'));
$this->Form->end(array('type' => 'submit', 'value' => 'Ajouter', 'class' => 'btn btn-info submit'));

?>
</div>
