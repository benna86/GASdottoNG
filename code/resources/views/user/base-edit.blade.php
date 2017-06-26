@include('commons.textfield', ['obj' => $user, 'name' => 'username', 'label' => 'Login', 'mandatory' => true])
@include('commons.textfield', ['obj' => $user, 'name' => 'firstname', 'label' => 'Nome', 'mandatory' => true])
@include('commons.textfield', ['obj' => $user, 'name' => 'lastname', 'label' => 'Cognome', 'mandatory' => true])
@include('commons.passwordfield', ['obj' => $user, 'name' => 'password', 'label' => 'Password', 'mandatory' => true])
@include('commons.datefield', ['obj' => $user, 'name' => 'birthday', 'label' => 'Data di Nascita'])
@include('commons.textfield', ['obj' => $user, 'name' => 'taxcode', 'label' => 'Codice Fiscale'])
@include('commons.textfield', ['obj' => $user, 'name' => 'family_members', 'label' => 'Persone in Famiglia'])
