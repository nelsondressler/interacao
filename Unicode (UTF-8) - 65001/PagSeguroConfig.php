<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php

/*
 ************************************************************************
 PagSeguro Config File
 ************************************************************************
 */

$PagSeguroConfig = array();

$PagSeguroConfig['environment'] = "production"; // production, sandbox

$PagSeguroConfig['credentials'] = array();
$PagSeguroConfig['credentials']['email'] = PAG_USUARIO;
$PagSeguroConfig['credentials']['token']['production'] = PAG_TOKEN_PROD;
$PagSeguroConfig['credentials']['token']['sandbox'] = PAG_TOKEN_SAND;

$PagSeguroConfig['application'] = array();
$PagSeguroConfig['application']['charset'] = "ISO-8859-1"; // UTF-8, ISO-8859-1

$PagSeguroConfig['log'] = array();
$PagSeguroConfig['log']['active'] = true;
$PagSeguroConfig['log']['fileLocation'] = "";
