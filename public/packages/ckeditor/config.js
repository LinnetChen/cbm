/**
 * @license Copyright (c) 2003-2022, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
    config.image_previewText = ' ';
    config.filebrowserUploadUrl = "/ckeditor/upload?opener=ckeditor&type=images";
    config.filebrowserUploadMethod = 'form';

    // config.filebrowserBrowseUrl ="/packages/ckfinder/ckfinder.html";
    // config.filebrowserImageBrowseUrl ="/packages/ckfinder/ckfinder.html";
    config.filebrowserBrowseUrl ="/packages/ckfinder/filePath.html";
    config.filebrowserImageBrowseUrl ="/packages/ckfinder/filePath.html";
    config.font_names = 'Arial/Arial, Helvetica, sans-serif;' +
    'Comic Sans MS/Comic Sans MS, cursive;' +
    'Courier New/Courier New, Courier, monospace;' +
    'Microsoft JhengHei/Microsoft JhengHei, sans-serif;' +
    'Tahoma/Tahoma, Geneva, sans-serif;' +
    'Times New Roman/Times New Roman, Times, serif;' +
    'Verdana/Verdana, Geneva, sans-serif';
};


// $(function(){
//     if($.cookie('refresh')!='no'){
//         setTimeout(function(){
//             window.location.reload();
//             $.cookie('refresh','no');
//         },3000);
//     }
// })
