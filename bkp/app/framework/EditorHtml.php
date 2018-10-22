<?php

require_once SYS_FRAMEWORK .'/editorhtml/fckeditor.php';

class EditorHtml
{
  
  public function create($name, $html = '', $heigth = '300') {
    
    $editor = new FCKeditor($name);
    $editor->Height    = $heigth;
    $editor->BasePath  = SYS_EDITOR;
    $editor->ToolbarSet = 'NeodreamPlus';
    $editor->Value      = $html;
    $editor->Config['SkinPath'] = SYS_EDITOR . 'editor/skins/neodream_plus/';
    $editor->Create();
    
  }
  
}