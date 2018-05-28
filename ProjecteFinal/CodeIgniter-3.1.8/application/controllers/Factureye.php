<?php
class Factureye extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('language');
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->library('grocery_CRUD');
        $this->load->library('html2pdf');
        $this->load->library('mydompdf');
        $this->load->model('factureye_model');
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');
    }
    private function createFolder()
    {
        if(!is_dir("./files"))
        {
            mkdir("./files", 0777);
            mkdir("./files/pdfs", 0777);
        }
    }
    public function index(){
        if ( ! file_exists(APPPATH.'views/factureye/inici.php')){
            // Ep! Aquesta pàgina no existeix
            show_404();
        }else{
            $data['noticia'] = $this->factureye_model->get_noticia();
            $this->load->view('templates/header');
            $this->load->view('factureye/inici', $data);
            $this->load->view('templates/footer');
        }
    }
    public function logout()
    {
        $this->data['title'] = "Logout";

        $logout = $this->ion_auth->logout();

        $this->session->set_flashdata('message', $this->ion_auth->messages());
        redirect('factureye/index', 'refresh');
    }
    public function principal(){
        if($this->input->post() ){
            $nom = $this->input->post('nom');
            $contrasenya = $this->input->post('contra');
           
            $recordar = $this->input->post('recordar');
            if($this->ion_auth->login($nom, $contrasenya, $recordar)){
                $this->factures();
                
            }else{
                redirect('factureye/index');
            }
        }else{
            redirect('factureye/index');
        }
    }
    public function factures(){
        if($this->ion_auth->logged_in() ){
            $data['arrayFactures'] = $this->factureye_model->get_factures();
            if(!$this->ion_auth->is_admin()){
                $this->load->view('templates/header');
                $this->load->view('templates/navbarUser');
                $this->load->view('factureye/factures', $data);
                $this->load->view('templates/footer');
            }
            else{
                $this->load->view('templates/header');
                $this->load->view('templates/navbarAdmin');
                $this->load->view('factureye/factures', $data);
                $this->load->view('templates/footer');
            }
        }else{
            redirect('factureye/index');
        }
    }
    public function eliminarFactura($id_factura){
        if($this->ion_auth->logged_in() ){
            $data['arrayInfoFactura'] = $this->factureye_model->infoFactura($id_factura);
            $id_venedor_actual = $this->ion_auth->get_user_id();
            $id_venedor_factura = $data['arrayInfoFactura'][0]['id'];
            if($id_venedor_actual==$id_venedor_factura || $this->ion_auth->is_admin()){
                $this->factureye_model->eliminarFactura($id_factura);
                redirect('factureye/factures', 'refresh');
            }
            else{
                echo "
                    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
                    <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js'></script>
                    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
                    <div class='alert alert-danger' role='alert'>
                        <strong>Error!</strong> No pots eliminar la factura d'un altre venedor.
                    </div>";
                redirect('factureye/factures', 'refresh');
            }
        }else{
            redirect('factureye/index');
        }
    }
    public function novaFactura(){
        if($this->ion_auth->logged_in() ){
            $data['arrayClients'] = $this->factureye_model->clientsNovaFactura();
            $data['arrayTreballadors'] = $this->factureye_model->treballadorsNovaFactura();
            $data['arrayUltimaFactura'] = $this->factureye_model->get_ultima_factures();
            if(!$this->ion_auth->is_admin()){
                $this->load->view('templates/header');
                $this->load->view('templates/navbarUser');
                $this->load->view('factureye/novaFactura', $data);
                $this->load->view('templates/footer');
            }
            else{
                $this->load->view('templates/header');
                $this->load->view('templates/navbarAdmin');
                $this->load->view('factureye/novaFactura', $data);
                $this->load->view('templates/footer');
            }
        }else{
            redirect('factureye/index');
        }
    }
    public function crearFactura(){
        if($this->ion_auth->logged_in() ){
            if($this->input->post()){
                $numero_factura = $this->input->post('numero_factura');
                $id_client = $this->input->post('client');
                $id_venedor = $this->ion_auth->get_user_id();
                
                if($numero_factura==""){
                    echo "
                        <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
                        <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js'></script>
                        <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
                        <div class='alert alert-danger' role='alert'>
                            <strong>Error!</strong> Tens que posar un numero de factura.
                        </div>";
                    redirect('factureye/factures', 'refresh');
                }
                else{
                    $id_factura = $this->factureye_model->crearFactu($numero_factura, $id_client, $id_venedor);
                    $this->afegirProductesFactura($id_factura);
                }
            }else{
                redirect('factureye/factures', 'refresh');
            }
            
        }else{
            redirect('factureye/index');
        }
    }
    public function afegirProductesFactura($id_factura){
        if($this->ion_auth->logged_in() ){
            $data['arrayProductes'] = $this->factureye_model->productesNovaFactura();
            $data['arrayInfoFactura'] = $this->factureye_model->infoFactura($id_factura);
            if(!$this->ion_auth->is_admin()){
                $this->load->view('templates/header');
                $this->load->view('templates/navbarUser');
                $this->load->view('factureye/afegirProductes', $data);
                $this->load->view('templates/footer');
            }
            else{
                $this->load->view('templates/header');
                $this->load->view('templates/navbarAdmin');
                $this->load->view('factureye/afegirProductes', $data);
                $this->load->view('templates/footer');
            }
        }else{
            redirect('factureye/index');
        }
    }
    public function inserirProductesQuantitat(){
        if($this->ion_auth->logged_in() ){
            if($this->input->post()){
                if($this->input->post('id')){
                    $id_factura = $this->input->post('id_factura');
                    $id_producte = $this->input->post('id');
                    $quant = $this->input->post('quantitat');
                    $quantitat = array_filter($quant, "strlen");
                    if(count($quantitat)!=count($id_producte)){
                        echo "
                            <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
                            <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js'></script>
                            <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
                            <div class='alert alert-danger' role='alert'>
                                <strong>Error!</strong> Tens que posar la quantitat dels productes sel·leccionats.
                            </div>";
                        redirect('factureye/factures', 'refresh');
                    }
                    else{
                        $this->factureye_model->afegirProductesAFactura($id_factura, $id_producte, $quantitat);
                        $this->veureFactura($id_factura);
                    }
                }else{
                    redirect('factureye/factures', 'refresh');
                }
            }else{
                redirect('factureye/factures', 'refresh');
            }
            
        }else{
            redirect('factureye/index');
        }
    }
    public function veureFactura($id_factura){
        if($this->ion_auth->logged_in()){
            $data['arrayInfoEmpresa'] = $this->factureye_model->get_info_empresa();
            $data['arrayProductesFactura'] = $this->factureye_model->ProductesFactura($id_factura);
            $data['arrayInfoFactura'] = $this->factureye_model->infoFactura($id_factura);
            $id_venedor_actual = $this->ion_auth->get_user_id();
            $id_venedor_factura = $data['arrayInfoFactura'][0]['id'];
            if($id_venedor_actual==$id_venedor_factura || $this->ion_auth->is_admin()){
                if(!$this->ion_auth->is_admin()){
                    $this->load->view('templates/header');
                    $this->load->view('templates/navbarUser');
                    $this->load->view('factureye/veureFactura', $data);
                    $this->load->view('templates/footer');
                }
                else{
                    $this->load->view('templates/header');
                    $this->load->view('templates/navbarAdmin');
                    $this->load->view('factureye/veureFactura', $data);
                    $this->load->view('templates/footer');
                }
            }
            else{
                echo "
                    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
                    <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js'></script>
                    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
                    <div class='alert alert-danger' role='alert'>
                        <strong>Error!</strong> No pots editar la factura d'un altre venedor.
                    </div>";
                redirect('factureye/factures', 'refresh');                
            }
        }else{
            redirect('factureye/index');
        }
    }
    public function modificarProducteFactura(){
        if($this->ion_auth->logged_in() ){
            if($this->input->post()){
                $id_factura = $this->input->post('id_factura');
                $id_producte = $this->input->post('id_producte');
                $quantitat = $this->input->post('quantitat');
                if($quantitat==''){
                    echo "
                        <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
                        <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js'></script>
                        <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
                        <div class='alert alert-danger' role='alert'>
                            <strong>Error!</strong> Tens que posar la quantitat del producte a modificar.
                        </div>";
                    $this->veureFactura($id_factura);
                }
                else{
                    $this->factureye_model->modificarQuantitatProducte($id_factura, $id_producte, $quantitat);
                    $this->veureFactura($id_factura);
                }
            }else{
                $this->veureFactura($id_factura);
            }
            
        }else{
            redirect('factureye/index');
        }
    }
    public function eliminarProducteFactura($id_factura, $id_producte){
        if($this->ion_auth->logged_in() ){
            $this->factureye_model->eliminarProducteFactura($id_factura, $id_producte);
            $this->veureFactura($id_factura);
        }else{
            redirect('factureye/index');
        }
    }
    public function actualitzarPreuEstatFactura(){
        if($this->ion_auth->logged_in() ){
            if($this->input->post()){
                $id_factura = $this->input->post('id_factura');
                $preu_final = $this->input->post('preu_final');
                $estat = $this->input->post('estat');
                $this->factureye_model->actualitzarPreuEstatFactura($id_factura, $preu_final, $estat);
                $this->factures();
            }else{
                $this->veureFactura($id_factura);
            }
            
        }else{
            redirect('factureye/index');
        }
    }
    public function configurar_web(){
        if($this->ion_auth->logged_in() ){
            if(!$this->ion_auth->is_admin()){
                $this->factures();
            }
            else{
                $data['arrayLogo'] = $this->factureye_model->get_logo_empresa();
                $data['info'] = $this->factureye_model->get_info_empresa();
                $this->load->view('templates/header');
                $this->load->view('templates/navbarAdmin');
                $this->load->view('factureye/configurar_web', $data);
                $this->load->view('templates/footer');
            }
        }else{
            redirect('factureye/index');
        }
    }
    public function modificar_config(){
        if($this->ion_auth->logged_in() ){
            if(!$this->ion_auth->is_admin()){
                $this->factures();
            }
            else{
                if($this->input->post()){
                    $nom_empresa = $this->input->post('nom_empresa');
                    $direccio = $this->input->post('direccio');
                    $ciutat = $this->input->post('ciutat');
                    $codi_postal = $this->input->post('codi_postal');
                    $provincia = $this->input->post('provincia');
                    $telefon = $this->input->post('telefon');
                    $email = $this->input->post('email');
                    $impost = $this->input->post('impost');
                    if($nom_empresa==""||$direccio==""||$ciutat==""||$codi_postal==""||$provincia==""||$telefon==""||$email==""||$impost==""){
                        echo "
                            <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
                            <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js'></script>
                            <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
                            <div class='alert alert-danger' role='alert'>
                                <strong>Error!</strong> Tens que rellenar totes les caselles.
                            </div>";
                        redirect('factureye/configurar_web', 'refresh');
                    }
                    else{
                        $maximo = 102400; //100Kb

                        if ( is_uploaded_file($_FILES['imagen']['tmp_name']) ) 
                        { 
                            $fp = fopen($_FILES['imagen']['tmp_name'], 'r');
                            $imagen = fread($fp, filesize($_FILES['imagen']['tmp_name']));
                            $imagen = addslashes($imagen);
                            
                            $desti_serv = FCPATH . "/img/".$_FILES['imagen']['name'];
                            move_uploaded_file($_FILES['imagen']['tmp_name'], $desti_serv);

                            fclose($fp);
                            if(!get_magic_quotes_gpc())
                                $nombre = addslashes($_FILES['imagen']['name']); // Arreglamos el Nombre
                            else 
                                $nombre = $_FILES['imagen']['name'];
                            
                            $this->factureye_model->modificar_info_empresa($nom_empresa, $direccio, $ciutat, $codi_postal, $provincia, $telefon, $email, $impost, $imagen, $nombre);
                            redirect('factureye/configurar_web', 'refresh');
                        } 
                        else{
                            $this->factureye_model->modificar_info_empresa_sense_foto($nom_empresa, $direccio, $ciutat, $codi_postal, $provincia, $telefon, $email, $impost);
                            redirect('factureye/configurar_web', 'refresh');
                        }
                    }
                }else{
                    redirect('factureye/configurar_web', 'refresh');
                }
            }
        }else{
            redirect('factureye/index');
        }
    }
    public function noticies(){
        if($this->ion_auth->logged_in() ){
            if(!$this->ion_auth->is_admin()){
                $this->factures();
            }
            else{
                $data['arrayNoticies'] = $this->factureye_model->get_noticies();
                $this->load->view('templates/header');
                $this->load->view('templates/navbarAdmin');
                $this->load->view('factureye/noticies', $data);
                $this->load->view('templates/footer');
            }
        }else{
            redirect('factureye/index');
        }
    }
    public function novaNoticia(){
        if($this->ion_auth->logged_in() ){
            if(!$this->ion_auth->is_admin()){
                $this->factures();
            }
            else{
                $this->load->view('templates/header');
                $this->load->view('templates/navbarAdmin');
                $this->load->view('factureye/nova_noticia');
                $this->load->view('templates/footer');
            }
        }else{
            redirect('factureye/index');
        }
    }
    public function penjar_noticia(){
        if($this->ion_auth->logged_in() ){
            if(!$this->ion_auth->is_admin()){
                $this->factures();
            }
            else{
                if($this->input->post()){
                    $titol_noticia = $this->input->post('titol_noticia');
                    $noticia = $this->input->post('noticia');
                    if($titol_noticia==""||$noticia==""){
                        echo "
                            <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
                            <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js'></script>
                            <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
                            <div class='alert alert-danger' role='alert'>
                                <strong>Error!</strong> Tens que introduir titol i cos de la noticia
                            </div>";
                        redirect('factureye/noticies', 'refresh');
                    }
                    else{
                        $maximo = 102400; //100Kb

                        if ( is_uploaded_file($_FILES['imagen']['tmp_name']) ) 
                        { 
                            $fp = fopen($_FILES['imagen']['tmp_name'], 'r');
                            $imagen = fread($fp, filesize($_FILES['imagen']['tmp_name']));
                            $imagen = addslashes($imagen);

                            fclose($fp);
                            $this->factureye_model->penjar_noticia_amb_foto($titol_noticia, $noticia, $imagen);
                            redirect('factureye/noticies', 'refresh');
                        } 
                        else{
                            $this->factureye_model->penjar_noticia_sense_foto($titol_noticia, $noticia);
                            redirect('factureye/noticies', 'refresh');
                        }
                    }
                }else{
                    redirect('factureye/noticies', 'refresh');
                }
            }
        }else{
            redirect('factureye/index');
        }
    }
    public function eliminarNoticia($id){
        if($this->ion_auth->logged_in() ){
            if(!$this->ion_auth->is_admin()){
                $this->factures();
            }
            else{
                $this->factureye_model->eliminarNoticia($id);
                redirect('factureye/noticies', 'refresh');
            }
        }else{
            redirect('factureye/index', 'refresh');
        }
    }
    public function modificarNoticia($id){
        if($this->ion_auth->logged_in() ){
            if(!$this->ion_auth->is_admin()){
                $this->factures();
            }
            else{
                $data['arrayNoticia'] = $this->factureye_model->get_noticia_a_modificar($id);
                $this->load->view('templates/header');
                $this->load->view('templates/navbarAdmin');
                $this->load->view('factureye/modificarNoticia', $data);
                $this->load->view('templates/footer');
            }
        }else{
            redirect('factureye/index', 'refresh');
        }
    }
    public function modificarInfoNoticia(){
        if($this->ion_auth->logged_in() ){
            if(!$this->ion_auth->is_admin()){
                $this->factures();
            }
            else{
                if($this->input->post()){
                    $id = $this->input->post('id');
                    $titol_noticia = $this->input->post('titol_noticia');
                    $noticia = $this->input->post('noticia');
                    if($titol_noticia==""||$noticia==""){
                        echo "
                            <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
                            <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js'></script>
                            <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
                            <div class='alert alert-danger' role='alert'>
                                <strong>Error!</strong> Tens que introduir titol i cos de la noticia
                            </div>";
                        redirect('factureye/noticies', 'refresh');
                    }
                    else{
                        $maximo = 102400; //100Kb

                        if ( is_uploaded_file($_FILES['imagen']['tmp_name']) ) 
                        { 
                            $fp = fopen($_FILES['imagen']['tmp_name'], 'r');
                            $imagen = fread($fp, filesize($_FILES['imagen']['tmp_name']));
                            $imagen = addslashes($imagen);

                            fclose($fp);
                            $this->factureye_model->modificar_info_noticia($id, $titol_noticia, $noticia, $imagen);
                            redirect('factureye/noticies', 'refresh');
                        } 
                        else{
                            $this->factureye_model->modificar_info_noticia_sense_foto($id, $titol_noticia, $noticia);
                            redirect('factureye/noticies', 'refresh');
                        }
                    }
                }else{
                   redirect('factureye/nouTreballador', 'refresh');
                }
            }
        }else{
            redirect('factureye/index', 'refresh');
        }
    }
    public function clients(){
        if($this->ion_auth->logged_in() ){
            if(!$this->ion_auth->is_admin()){
                $this->load->view('templates/header');
                $this->load->view('templates/navbarUser');
                $this->load->view('factureye/clients');
                $this->load->view('templates/footer');
            }
            else{
                $this->load->view('templates/header');
                $this->load->view('templates/navbarAdmin');
                $this->load->view('factureye/clients');
                $this->load->view('templates/footer');
            }
        }else{
            redirect('factureye/index');
        }
    }
    public function grocery_clients(){
        if($this->ion_auth->logged_in() ){
            $crud = new grocery_CRUD();

            $crud->set_language("catalan");
            $crud->set_theme('flexigrid');

            $crud->set_table('clients')
                    ->set_subject('Client')
                    ->columns('nom_client','telefon_client','email_client','direccio_client','estat_client', 'data_alta')
                    ->display_as('nom_client','Nom i Cognoms')
                    ->display_as('telefon_client','Telefon')
                    ->display_as('email_client','Correu Electronic')
                    ->display_as('direccio_client','Direccio (Domicili)')
                    ->display_as('estat_client','Estat (Actiu: 1, Inactiu: 0)')
                    ->display_as('data_alta','Data Alta');

            $crud->fields('nom_client','telefon_client','email_client','direccio_client','estat_client', 'data_alta');

            $output = $crud->render();

            $this->mostrar_taula_clients($output);
        }else{
            redirect('factureye/index', 'refresh');
        }
    }
    public function mostrar_taula_clients($output = null){
        if($this->ion_auth->logged_in() ){
            $this->load->view('example.php',$output);
        }else{
            redirect('factureye/index', 'refresh');
        }
    }
    public function treballadors(){
        if($this->ion_auth->logged_in() ){
            if(!$this->ion_auth->is_admin()){
                $this->factures();
            }
            else{
                $data['arrayUsuaris'] = $this->factureye_model->get_treballadors();
                $this->load->view('templates/header');
                $this->load->view('templates/navbarAdmin');
                $this->load->view('factureye/treballadors', $data);
                $this->load->view('templates/footer');
            }
        }else{
            redirect('factureye/index', 'refresh');
        }
    }
    public function eliminarTreballador(){
        if($this->ion_auth->logged_in() ){
            if(!$this->ion_auth->is_admin()){
                $this->factures();
            }
            else{
                if($this->input->post()){
                    $id = $this->input->post('id');
                    //echo "<pre>".print_r($id)."</pre>";
                    $this->factureye_model->eliminarTreballador($id);
                    redirect('factureye/treballadors', 'refresh');
                    
                }else{
                    redirect('factureye/treballadors', 'refresh');
                }
            }
        }else{
            redirect('factureye/index', 'refresh');
        }
    }
    public function nouTreballador(){
        if($this->ion_auth->logged_in() ){
            if(!$this->ion_auth->is_admin()){
                $this->factures();
            }
            else{
                $this->load->view('templates/header');
                $this->load->view('templates/navbarAdmin');
                $this->load->view('factureye/nou_treballador');
                $this->load->view('templates/footer');
            }
        }else{
            redirect('factureye/index', 'refresh');
        }
    }
    public function afegirTreballador(){
        if($this->ion_auth->logged_in() ){
            if(!$this->ion_auth->is_admin()){
                $this->factures();
            }
            else{
                if($this->input->post()){
                    $first_name = $this->input->post('first_name');
                    $last_name = $this->input->post('last_name');
                    $username = $this->input->post('username');
                    $password = $this->input->post('password');
                    $email = $this->input->post('email');
                    $phone = $this->input->post('phone');
                    $active = $this->input->post('active');
                    $grup = $this->input->post('grup');
                    if($first_name==""||$last_name==""||$username==""||$password==""||$email==""||$phone==""||$grup==""){
                        echo "
                            <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
                            <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js'></script>
                            <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
                            <div class='alert alert-danger' role='alert'>
                                <strong>Error!</strong> Tens que introduir tota la informació de l'usuari
                            </div>";
                        redirect('factureye/nouTreballador', 'refresh');
                    }
                    else{
                        $this->factureye_model->afegirTreballador($first_name, $last_name, $username, $password, $email, $phone, $active, $grup);
                        redirect('factureye/treballadors', 'refresh');
                    }
                }else{
                    redirect('factureye/nouTreballador', 'refresh');
                }
            }
        }else{
            redirect('factureye/index', 'refresh');
        }
    }
    public function modificarTreballador($id){
        if($this->ion_auth->logged_in() ){
            if(!$this->ion_auth->is_admin()){
                $this->factures();
            }
            else{
                $data['arrayUsuari'] = $this->factureye_model->get_treballador_a_modificar($id);
                $this->load->view('templates/header');
                $this->load->view('templates/navbarAdmin');
                $this->load->view('factureye/modificarTreballador', $data);
                $this->load->view('templates/footer');
            }
        }else{
            redirect('factureye/index', 'refresh');
        }
    }
    public function modificarInfoTreballador(){
        if($this->ion_auth->logged_in() ){
            if(!$this->ion_auth->is_admin()){
                $this->factures();
            }
            else{
                if($this->input->post()){
                    $id = $this->input->post('id');
                    $first_name = $this->input->post('first_name');
                    $last_name = $this->input->post('last_name');
                    $username = $this->input->post('username');
                    $password = $this->input->post('password');
                    $email = $this->input->post('email');
                    $phone = $this->input->post('phone');
                    $grup = $this->input->post('grup');
                    if($first_name==""||$last_name==""||$username==""||$email==""||$phone==""||$grup==""){
                        echo "
                            <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
                            <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js'></script>
                            <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
                            <div class='alert alert-danger' role='alert'>
                                <strong>Error!</strong> Tens que introduir tota la informació a modificar del usuari
                            </div>";
                        redirect('factureye/nouTreballador', 'refresh');
                    }
                    else{
                        $this->factureye_model->modificarTreballador($id, $first_name, $last_name, $username, $password, $email, $phone, $grup);
                        redirect('factureye/treballadors', 'refresh');
                    }
                }else{
                    redirect('factureye/nouTreballador', 'refresh');
                }
            }
        }else{
            redirect('factureye/index', 'refresh');
        }
    }
    public function productes(){
        if($this->ion_auth->logged_in() ){
            if(!$this->ion_auth->is_admin()){
                $this->load->view('templates/header');
                $this->load->view('templates/navbarUser');
                $this->load->view('factureye/productes');
                $this->load->view('templates/footer');
            }
            else{
                $this->load->view('templates/header');
                $this->load->view('templates/navbarAdmin');
                $this->load->view('factureye/productes');
                $this->load->view('templates/footer');
            }
        }else{
            redirect('factureye/index', 'refresh');
        }
    }
    public function grocery_productes(){
        if($this->ion_auth->logged_in() ){
            $crud = new grocery_CRUD();

            $crud->set_language("catalan");
            $crud->set_theme('flexigrid');

            $crud->set_table('productes')
                    ->set_subject('Producte')
                    ->columns('codi_producte','nom_producte','estat_producte','data_afegit','marca_producte', 'categoria', 'subcategoria', 'preu_producte')
                    ->display_as('codi_producte','Codi')
                    ->display_as('nom_producte','Nom')
                    ->display_as('estat_producte','Estat (Disponible: 1, Esgotat: 0)')
                    ->display_as('data_afegit','Data Afegit')
                    ->display_as('marca_producte','Marca')
                    ->display_as('categoria','Categoria')
                    ->display_as('subcategoria','Subcategoria')
                    ->display_as('preu_producte','Preu (€)');

            $crud->fields('codi_producte','nom_producte','estat_producte','data_afegit','marca_producte', 'categoria', 'subcategoria', 'preu_producte');

            $output = $crud->render();

            $this->mostrar_taula_productes($output);
        }else{
            redirect('factureye/index', 'refresh');
        }
    }
    public function mostrar_taula_productes($output = null){
        if($this->ion_auth->logged_in() ){
            $this->load->view('example.php',$output);
        }else{
            redirect('factureye/index', 'refresh');
        }
    }
    public function generar_pdf($id_factura){
        if($this->ion_auth->logged_in() ){
            /*
             * Estableixo la carpeta on vull que es guardin els pdfs i si no existeix la creo i li dono permisos
             */
            $this->createFolder();
            $this->html2pdf->folder('./files/pdfs/');
            //establim el nom del arxiu
            $this->html2pdf->filename('test.pdf');
            //establim el tipus de paper
            $this->html2pdf->paper('a4', 'portrait');
            
            $data['arrayLogo'] = $this->factureye_model->get_logo_empresa();
            $data['arrayInfoEmpresa'] = $this->factureye_model->get_info_empresa();
            $data['arrayProductesFactura'] = $this->factureye_model->ProductesFactura($id_factura);
            $data['arrayInfoFactura'] = $this->factureye_model->infoFactura($id_factura);
            $this->html2pdf->html(utf8_decode($this->load->view('factureye/pdf/factura', $data, true)));
            //si el pdf es guarda correctament el mostro per pantalla
            if($this->html2pdf->create('save')) 
            {
                $this->show();
            }
        }else{
            redirect('factureye/index', 'refresh');
        }
    }
    //esta función muestra el pdf en el navegador siempre que existan
    //tanto la carpeta como el archivo pdf
    public function show()
    {
        if($this->ion_auth->logged_in() ){ 
            if(is_dir("./files/pdfs"))
            {
                $filename = "test.pdf"; 
                $route = base_url("files/pdfs/test.pdf"); 
                if(file_exists("./files/pdfs/".$filename))
                {
                    header('Content-type: application/pdf'); 
                    readfile($route);
                }
            }
        }else{
            redirect('factureye/index', 'refresh');
        }
    }
}