<?php
class Factureye_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
    }
    public function get_noticia(){
        $query = $this->db->query("select titol_noticia, noticia, imatge from noticies_externes where id_noticia = (select id_noticia from noticies_externes ORDER BY data DESC LIMIT 1)");
        $row = $query->row();
        if (isset($row))
        {   
            $titol_noticia = $row->titol_noticia;
            $noticia = $row->noticia;
            $imatge = $row->imatge;
        }
        else{
            $titol_noticia = "";
            $noticia = "";
            $imatge = "";
        }

        $arr = array('titol_noticia'=>$titol_noticia,
                    'noticia'=>$noticia,
                    'imatge'=>$imatge
            );
        return $arr;
    }
    public function get_logo_empresa(){
        $query = $this->db->query("select logo, nom from info_empresa where id_perfil=1");
        $row = $query->row();
        if (isset($row))
        {   
            $logo = $row->logo;
            $nom = $row->nom;
        }else{
            $logo = false;
            $nom = false;
        }
        $info = array('logo'=>$logo, 'nom'=>$nom);
        return $info;
    }
    public function get_info_empresa(){
        $query = $this->db->query("select nom_empresa, direccio, ciutat, codi_postal, provincia, telefon, email, impost from info_empresa where id_perfil=1");
        $row = $query->row();
        if (isset($row))
        {   
            $nom_empresa = $row->nom_empresa; $direccio = $row->direccio; $ciutat = $row->ciutat; $codi_postal = $row->codi_postal; 
            $provincia = $row->provincia; $telefon = $row->telefon; $email = $row->email; $impost = $row->impost;
        }else{
            $nom_empresa="Nom Empresa"; $direccio="Direccio"; $ciutat="Ciutat"; $codi_postal="Codi Postal"; $provincia="Provincia"; $telefon="Telefon"; $email="Correu Electronic"; $impost="0";
        }
        $info = array('nom_empresa'=>$nom_empresa, 'direccio'=>$direccio, 'ciutat'=>$ciutat, 'codi_postal'=>$codi_postal, 'provincia'=>$provincia,
                    'telefon'=>$telefon, 'email'=>$email, 'impost'=>$impost
            );
        return $info;
    }
    public function modificar_info_empresa($nom_empresa, $direccio, $ciutat, $codi_postal, $provincia, $telefon, $email, $impost, $imagen, $nombre){
        $query = $this->db->query('select id_perfil from info_empresa where id_perfil=1');
        $row = $query->row();
        if (isset($row))
        {   
            $id_perfil = $row->id_perfil;
            $query = $this->db->query('UPDATE info_empresa SET nom_empresa="'.$nom_empresa.'", direccio="'.$direccio.'", ciutat="'.$ciutat.'", codi_postal="'.$codi_postal.'", provincia="'.$provincia.'", telefon="'.$telefon.'", email="'.$email.'", impost="'.$impost.'", logo="'.$imagen.'", nom="'.$nombre.'" WHERE id_perfil='.$id_perfil);
        }else{
            $id_perfil = 1;
            $query = $this->db->query('insert into info_empresa (id_perfil, nom_empresa, direccio, ciutat, codi_postal, provincia, telefon, email, impost, logo, nom) values ('.$id_perfil.', "'.$nom_empresa.'", "'.$direccio.'", "'.$ciutat.'", "'.$codi_postal.'", "'.$provincia.'", "'.$telefon.'", "'.$email.'", "'.$impost.'", "'.$imagen.'", "'.$nombre.'")');
        }
    }
    public function modificar_info_empresa_sense_foto($nom_empresa, $direccio, $ciutat, $codi_postal, $provincia, $telefon, $email, $impost){
        $query = $this->db->query('select id_perfil from info_empresa where id_perfil=1');
        $row = $query->row();
        if (isset($row))
        {   
            $id_perfil = $row->id_perfil;
            $query = $this->db->query('UPDATE info_empresa SET nom_empresa="'.$nom_empresa.'", direccio="'.$direccio.'", ciutat="'.$ciutat.'", codi_postal="'.$codi_postal.'", provincia="'.$provincia.'", telefon="'.$telefon.'", email="'.$email.'", impost="'.$impost.'" WHERE id_perfil='.$id_perfil);
        }else{
            $id_perfil = 1;
            $query = $this->db->query('insert into info_empresa (id_perfil, nom_empresa, direccio, ciutat, codi_postal, provincia, telefon, email, impost, logo, nom) values ('.$id_perfil.', "'.$nom_empresa.'", "'.$direccio.'", "'.$ciutat.'", "'.$codi_postal.'", "'.$provincia.'", "'.$telefon.'", "'.$email.'", "'.$impost.'", "", "")');
        }
    }
    public function get_noticies(){
        $query = $this->db->query('select id_noticia, titol_noticia, noticia, imatge, data from noticies_externes');
        $arrayNoticies = $query->result_array();
        return $arrayNoticies;
    }
    public function eliminarNoticia($id){
        $query = $this->db->query("delete from noticies_externes where id_noticia=".$id);
    }
    public function penjar_noticia_amb_foto($titol_noticia, $noticia, $imagen){
       $query = $this->db->query('insert into noticies_externes (id_noticia, titol_noticia, noticia, imatge, data) values (null, "'.$titol_noticia.'", "'.$noticia.'", "'.$imagen.'", CURRENT_TIMESTAMP)');
    }
    public function penjar_noticia_sense_foto($titol_noticia, $noticia){
       $query = $this->db->query('insert into noticies_externes (id_noticia, titol_noticia, noticia, imatge, data) values (null, "'.$titol_noticia.'", "'.$noticia.'", "", CURRENT_TIMESTAMP)');
    }
    public function get_noticia_a_modificar($id){
        $query = $this->db->query('select id_noticia, titol_noticia, noticia from noticies_externes where id_noticia='.$id);
        $arrayNoticia = $query->result_array();
        return $arrayNoticia;
    }
    public function modificar_info_noticia($id, $titol_noticia, $noticia, $imagen){
       $query = $this->db->query('update noticies_externes set titol_noticia = "'.$titol_noticia.'", noticia = "'.$noticia.'", imatge = "'.$imagen.'", data = CURRENT_TIMESTAMP where id_noticia = '.$id);
    }
    public function modificar_info_noticia_sense_foto($id, $titol_noticia, $noticia){
       $query = $this->db->query('update noticies_externes set titol_noticia = "'.$titol_noticia.'", noticia = "'.$noticia.'", data = CURRENT_TIMESTAMP where id_noticia = '.$id);
    }
    public function get_treballadors(){
        $query = $this->db->query('select id, username, password, email, first_name, last_name, phone from users');
        $arrayUsuaris = $query->result_array();
        return $arrayUsuaris;
    }
    public function eliminarTreballador($id){
        $num_ides = sizeof($id);
        for ($i=0; $i<$num_ides; $i++){
            $query = $this->db->query("delete from users where id=".$id[$i]);
        }
    }
    public function afegirTreballador($first_name, $last_name, $username, $password, $email, $phone, $active, $grup){
        $password_hashed = $this->bcrypt->hash($password);
        $query = $this->db->query('insert into users (id, username, password, email, first_name, last_name, active, phone) values (null, "'.$username.'", "'.$password_hashed.'", "'.$email.'", "'.$first_name.'", "'.$last_name.'", "'.$active.'", "'.$phone.'")');
        $id_treballador = $this->db->insert_id();
        $query = $this->db->query('insert into users_groups (id, user_id, group_id) values (null, "'.$id_treballador.'", "'.$grup.'")');
    }
    public function get_treballador_a_modificar($id){
        $query = $this->db->query('select id, username, password, email, first_name, last_name, phone from users where id='.$id);
        $arrayUsuari = $query->result_array();
        return $arrayUsuari;
    }
    public function modificarTreballador($id, $first_name, $last_name, $username, $password, $email, $phone, $grup){
        if ($password==""){
            $query = $this->db->query('update users set username="'.$username.'", email="'.$email.'", first_name="'.$first_name.'", last_name="'.$last_name.'", phone="'.$phone.'" where id = '.$id);
        }else{
            $password_hashed = $this->bcrypt->hash($password);
            $query = $this->db->query('update users set username="'.$username.'", password="'.$password_hashed.'",email="'.$email.'", first_name="'.$first_name.'", last_name="'.$last_name.'", phone="'.$phone.'" where id = '.$id);
        }
        $query = $this->db->query('update users_groups set group_id = "'.$grup.'" where user_id = '.$id);
    }
    public function get_factures(){
        $query = $this->db->query('select f.id_factura, f.numero_factura, f.data_factura, f.total_venta, f.estat_factura, c.id_client, c.nom_client, t.id, t.first_name, t.last_name from factures as f join clients as c on f.id_client=c.id_client join users as t on f.id_venedor=t.id order by f.numero_factura');
        $arrayFactures = $query->result_array();
        return $arrayFactures;
    }
    public function get_ultima_factures(){
        $query = $this->db->query('select * from factures where id_factura=(select max(id_factura) from factures)');
        $arrayUltimaFactura = $query->result_array();
        return $arrayUltimaFactura;
    }
    public function eliminarFactura($id_factura){
        $query = $this->db->query("delete from objectes_factura where id_fact=".$id_factura);
        $query = $this->db->query("delete from factures where id_factura=".$id_factura);
    }
    public function clientsNovaFactura(){
        $query = $this->db->query('select id_client, nom_client from clients');
        $arrayClients = $query->result_array();
        return $arrayClients;
    }
    public function treballadorsNovaFactura(){
        $query = $this->db->query('select id, first_name, last_name from users');
        $arrayTreballadors = $query->result_array();
        return $arrayTreballadors;
    }
    public function crearFactu($numero_factura, $id_client, $id_venedor){
        $query = $this->db->query('insert into factures (id_factura, numero_factura, data_factura, id_client, id_venedor, total_venta, estat_factura) values (null, "'.$numero_factura.'", CURRENT_TIMESTAMP, "'.$id_client.'", "'.$id_venedor.'", 0, 0)');
        $id_factura = $this->db->insert_id();
        return $id_factura;
    }
    public function infoFactura($id_factura){
        $query = $this->db->query('select f.id_factura, f.numero_factura, f.data_factura, f.total_venta, f.estat_factura, c.id_client, c.nom_client, t.id, t.first_name, t.last_name from factures as f join clients as c on f.id_client=c.id_client join users as t on f.id_venedor=t.id where id_factura='.$id_factura);
        $arrayInfoFactura = $query->result_array();
        return $arrayInfoFactura;
    }
    public function productesNovaFactura(){
        $query = $this->db->query('select * from productes');
        $arrayProductes = $query->result_array();
        return $arrayProductes;
    }
    public function afegirProductesAFactura($id_factura, $id_producte, $quantitat){
        $num_ides = sizeof($id_producte);
        for ($i=0; $i<$num_ides; $i++){
            $query = $this->db->query('select id_prod from objectes_factura where id_fact='.$id_factura.' AND id_prod='.$id_producte[$i]);
            $row = $query->row();
            if (isset($row))
            {   
                $query = $this->db->query('UPDATE objectes_factura SET quantitat="'.$quantitat[$i].'" WHERE id_fact='.$id_factura.' AND id_prod='.$id_producte[$i]);
            }else{
                $query = $this->db->query('insert into objectes_factura (id_obj_fact, id_fact, id_prod, quantitat) values (null, "'.$id_factura.'", "'.$id_producte[$i].'", "'.$quantitat[$i].'")');
            }
            
        }
    }
    public function ProductesFactura($id_factura){
        $query = $this->db->query('select o.id_obj_fact, o.id_fact, o.id_prod, o.quantitat, p.id_producte, p.codi_producte, p.nom_producte, p.preu_producte from objectes_factura as o join productes as p on o.id_prod=p.id_producte where o.id_fact='.$id_factura);
        $arrayProductesFactura = $query->result_array();
        return $arrayProductesFactura;
    }
    public function modificarQuantitatProducte($id_factura, $id_producte, $quantitat){
        $query = $this->db->query('update objectes_factura set quantitat = '.$quantitat.' where id_fact = '.$id_factura.' AND id_prod = '.$id_producte);
    }
    public function eliminarProducteFactura($id_factura, $id_producte){
        $query = $this->db->query("delete from objectes_factura where id_fact=".$id_factura." and id_prod=".$id_producte);
    }
    public function actualitzarPreuEstatFactura($id_factura, $preu_final, $estat){
        $query = $this->db->query('update factures set total_venta = '.$preu_final.', estat_factura = '.$estat.' where id_factura = '.$id_factura);
    }
}