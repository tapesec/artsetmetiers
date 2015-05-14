<?php
class RessourceController extends Controller {

	public $helpers = array('Form', 'DateHelper'); 
	
	/**
	 *@name index
	 *@description page d'accueil des ressources disponibles
	 *@return la vue de la page d'accueil des ressources
	 * */
	public function index() {
		$this->layout = 'forum';
		$this->render('index');
	}
	/**
	*
	*
	*
	*
	* */
	public function voir($keyPress) {
		$this->loadModel('Ressource');
		$this->loadModel('Unite');
		$unite = $this->Unite->search(array('fields' => 'uni_id',
						   'like' => array('uni_name' => '%'.$keyUp.'%', 'OR' => true, 'uni_code' => '%'.$keyUp.'%'),
						   'order' => 'uni_name ASC'));

		$identifiant = current(current($unite));	
		$ressources = $this->Ressource->find(array('where' => array('sup_uni_id' => $identifiant)));

		foreach($ressources as $k => $v): ?>
		<tr>
		<td><?php echo $v['sup_name']; ?></td>
		<td><?php echo $v['sup_dateC']; ?></td>
		<td><?php echo $v['sup_size']; ?></td>
		<td><?php echo $v['sup_type']; ?></td>
		<td><a href="<?php echo $v['sup_url']; ?>">Télécharger</a></td>	
		</tr>			
		<?php endforeach; 
	}



}


?>
