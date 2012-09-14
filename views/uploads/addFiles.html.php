<?php
/**
 * Li3Press: A CMS with the Lithium (Li3) framework
 *
 * @author          Romain Wurtz (http://www.t3kila.com)
 * @copyright     Copyright 2012, Romain Wurtz (http://www.t3kila.com)
 * 
 */
?>

<style>
    .fileinput-button input {
        -moz-border-bottom-colors: none;
        -moz-border-left-colors: none;
        -moz-border-right-colors: none;
        -moz-border-top-colors: none;
        -moz-transform: translate(-300px, 0px) scale(4);
        border-color: transparent;
        border-image: none;
        border-style: solid;
        border-width: 0 0 100px 200px;
        cursor: pointer;
        direction: ltr;
        margin: 0;
        opacity: 0;
        position: absolute;
        right: 0;
        top: 0;
    }


    .modal-gallery{width:auto;max-height:none;}
    .modal-gallery .modal-body{max-height:none;}
    .modal-gallery .modal-title{display:inline-block;max-height:54px;overflow:hidden;}
    .modal-gallery .modal-image{position:relative;margin:auto;min-width:128px;min-height:128px;overflow:hidden;cursor:pointer;}
    .modal-gallery .modal-image:hover:before,.modal-gallery .modal-image:hover:after{content:'\2039';position:absolute;top:50%;left:15px;width:40px;height:40px;margin-top:-20px;font-size:60px;font-weight:100;line-height:30px;color:#ffffff;text-align:center;background:#222222;border:3px solid #ffffff;-webkit-border-radius:23px;-moz-border-radius:23px;border-radius:23px;opacity:0.5;filter:alpha(opacity=50);z-index:1;}
    .modal-gallery .modal-image:hover:after{content:'\203A';left:auto;right:15px;}
    .modal-single .modal-image:hover:before,.modal-single .modal-image:hover:after{display:none;}
    .modal-loading .modal-image{background:url(../img/loading.gif) center no-repeat;}
    .modal-gallery.fade .modal-image{-webkit-transition:width 0.15s ease, height 0.15s ease;-moz-transition:width 0.15s ease, height 0.15s ease;-ms-transition:width 0.15s ease, height 0.15s ease;-o-transition:width 0.15s ease, height 0.15s ease;transition:width 0.15s ease, height 0.15s ease;}
    .modal-gallery .modal-image *{position:absolute;top:0;opacity:0;filter:alpha(opacity=0);}
    .modal-gallery.fade .modal-image *{-webkit-transition:opacity 0.5s linear;-moz-transition:opacity 0.5s linear;-ms-transition:opacity 0.5s linear;-o-transition:opacity 0.5s linear;transition:opacity 0.5s linear;}
    .modal-gallery .modal-image *.in{opacity:1;filter:alpha(opacity=100);}
    .modal-fullscreen{border:none;-webkit-border-radius:0;-moz-border-radius:0;border-radius:0;background:transparent;overflow:hidden;}
    .modal-fullscreen.modal-loading{border:0;-webkit-box-shadow:none;-moz-box-shadow:none;box-shadow:none;}
    .modal-fullscreen .modal-body{padding:0;}
    .modal-fullscreen .modal-header,.modal-fullscreen .modal-footer{position:absolute;top:0;right:0;left:0;background:transparent;border:0;-webkit-box-shadow:none;-moz-box-shadow:none;box-shadow:none;opacity:0;z-index:2000;}
    .modal-fullscreen .modal-footer{top:auto;bottom:0;}
    .modal-fullscreen .close,.modal-fullscreen .modal-title{color:#fff;text-shadow:0 0 2px rgba(33, 33, 33, 0.8);}
    .modal-fullscreen .modal-header:hover,.modal-fullscreen .modal-footer:hover{opacity:1;}
    @media (max-width:480px){.modal-gallery .btn span{display:none;}}

    body {
        color: #333333;
        font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
        font-size: 13px;
        line-height: 18px;
    }
</style>

<div class="container">
    <div class="page-header">
        <h1>jQuery File Upload Demo</h1>
    </div>
    <blockquote>
        <p>File Upload widget with multiple file selection, drag&amp;drop support, progress bars and preview images for jQuery.<br>
            Supports cross-domain, chunked and resumable file uploads and client-side image resizing.<br>
            Works with any server-side platform (PHP, Python, Ruby on Rails, Java, Node.js, Go etc.) that supports standard HTML form file uploads.</p>
    </blockquote>
    <br>
    <div class="alert-area"></div>

    <!-- The file upload form used as target for the file upload widget -->
    <form id="fileupload" action="<?php echo $this->url(array('Uploads::addAction', 'type' => 'json')); ?>" method="POST" enctype="multipart/form-data">
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="row fileupload-buttonbar">
            <div class="span7">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <i class="icon-plus icon-white"></i>
                    <span>Add files...</span>
                    <input type="file" name="files[]" multiple>
                </span>
                <button type="submit" class="btn btn-primary start">
                    <i class="icon-upload icon-white"></i>
                    <span>Start upload</span>
                </button>
                <button type="reset" class="btn btn-warning cancel">
                    <i class="icon-ban-circle icon-white"></i>
                    <span>Cancel upload</span>
                </button>
                <button type="button" class="btn btn-danger delete">
                    <i class="icon-trash icon-white"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" class="toggle">
            </div>
            <!-- The global progress information -->
            <div class="span5 fileupload-progress fade">
                <!-- The global progress bar -->
                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="bar" style="width:0%;"></div>
                </div>
                <!-- The extended global progress information -->
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
        <!-- The loading indicator is shown during file processing -->
        <div class="fileupload-loading"></div>
        <br>
        <!-- The table listing the files available for upload/download -->
        <table role="presentation" class="table table-striped"><tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody></table>
    </form>
    <br>
    <div class="well">
        <h3>Demo Notes</h3>
        <ul>
            <li>The maximum file size for uploads in this demo is <strong>5 MB</strong> (default file size is unlimited).</li>
            <li>Only image files (<strong>JPG, GIF, PNG</strong>) are allowed in this demo (by default there is no file type restriction).</li>
            <li>Uploaded files will be deleted automatically after <strong>5 minutes</strong> (demo setting).</li>
            <li>You can <strong>drag &amp; drop</strong> files from your desktop on this webpage with Google Chrome, Mozilla Firefox and Apple Safari.</li>
            <li>Please refer to the <a href="https://github.com/blueimp/jQuery-File-Upload">project website</a> and <a href="https://github.com/blueimp/jQuery-File-Upload/wiki">documentation</a> for more information.</li>
            <li>Built with Twitter's <a href="http://twitter.github.com/bootstrap/">Bootstrap</a> toolkit and Icons from <a href="http://glyphicons.com/">Glyphicons</a>.</li>
        </ul>
    </div>
</div>


<div id="modal-gallery" class="modal modal-gallery hide fade">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h3 class="modal-title"></h3>
    </div>
    <div class="modal-body"><div class="modal-image"></div></div>
    <div class="modal-footer">
        <a class="btn btn-primary modal-next">Next <i class="icon-arrow-right icon-white"></i></a>
        <a class="btn btn-info modal-prev"><i class="icon-arrow-left icon-white"></i> Previous</a>
        <a class="btn btn-success modal-play modal-slideshow" data-slideshow="5000"><i class="icon-play icon-white"></i> Slideshow</a>
        <a class="btn modal-download" target="_blank"><i class="icon-download"></i> Download</a>
    </div>
</div>

<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td class="preview"><span class="fade"></span></td>
        <td class="name"><span>{%=file.name%}</span></td>
        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
        {% if (file.error) { %}
        <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else if (o.files.valid && !i) { %}
        <td>
            <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div>
        </td>
        <td class="start">{% if (!o.options.autoUpload) { %}
            <button class="btn btn-primary">
                <i class="icon-upload icon-white"></i>
                <span>{%=locale.fileupload.start%}</span>
            </button>
            {% } %}</td>
        {% } else { %}
        <td colspan="2"></td>
        {% } %}
        <td class="cancel">{% if (!i) { %}
            <button class="btn btn-warning">
                <i class="icon-ban-circle icon-white"></i>
                <span>{%=locale.fileupload.cancel%}</span>
            </button>
            {% } %}</td>
    </tr>
    {% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { 
    %}
    <tr class="template-download fade" data-id="{%=file.upload_id%}" style="height:100px">

        <td class="preview">{% if (file.thumbnail_url) { %}


            <a href="{%=file.url%}" title="{%=file.filename%}" rel="gallery"><img src="{%=file.thumbnail_url%}"></a>





            {% } %}</td>
        <td class="name">
            <a href="{%=file.url%}" title="{%=file.filename%}" rel="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.filename%}">{%=file.filename%}</a>
        </td>
        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
        <td colspan="2"></td>
        <td>
            <button class="btn btn-danger delete_button">
                <i class="icon-trash icon-white"></i>
                <span>{%=locale.fileupload.destroy%}</span>
            </button>
        </td>
    </tr>
    {% } %}
</script>




<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<?php echo $this->html->script(array('upload/vendor/jquery.ui.widget')); ?>

<!-- The Templates plugin is included to render the upload/download listings -->
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<!-- Bootstrap JS and Bootstrap Image Gallery are not required, but included for the demo -->
<?php echo $this->html->script(array('upload/tmpl.min')); ?>
<?php echo $this->html->script(array('upload/canvas-to-blob.min')); ?>

<?php echo $this->html->script(array('upload/load-image.min')); ?>
<?php echo $this->html->script(array('bootstrap-image-gallery.min')); ?>




<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="/js/upload/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="/js/upload/jquery.fileupload.js"></script>
<!-- The File Upload file processing plugin -->
<script src="/js/upload/jquery.fileupload-fp.js"></script>
<!-- The File Upload user interface plugin -->
<script src="/js/upload/jquery.fileupload-ui.js"></script>
<!-- The localization script -->
<script src="/js/upload/locale.js"></script>
<!-- The main application script -->
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE8+ -->
<!--[if gte IE 8]><script src="js/cors/jquery.xdr-transport.js"></script><![endif]-->

<script>
    
    $(document).ready(function () {

    


    
    
        // Initialize the jQuery File Upload widget:
        $('#fileupload').fileupload();

        // Enable iframe cross-domain access via redirect option:
        $('#fileupload').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
        /\/[^\/]*$/,
        '/cors/result.html?%s'
    )
    );
        
        
        $('#fileupload').bind('fileuploaddone', function (e, data) {
            if (data && data.result && data.result.files) {
                if (data.result.success) {
                    displaySuccessNotice(null, null);
                } else displayErrorNotice(data.result.details, null);
                // Make sure we use the correct plugin way.
                data.result = data.result.files;           
            } else displayErrorNotice(null, null);

  
        });

        
        

        if (window.location.hostname === 'blueimp.github.com') {
            // Demo settings:
            $('#fileupload').fileupload('option', {
                url: '//jquery-file-upload.appspot.com/',
                maxFileSize: 5000000,
                acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
                process: [
                    {
                        action: 'load',
                        fileTypes: /^image\/(gif|jpeg|png)$/,
                        maxFileSize: 20000000 // 20MB
                    },
                    {
                        action: 'resize',
                        maxWidth: 1440,
                        maxHeight: 900
                    },
                    {
                        action: 'save'
                    }
                ]
            });
            // Upload server status check for browsers with CORS support:
            if ($.support.cors) {
                $.ajax({
                    url: '//jquery-file-upload.appspot.com/',
                    type: 'HEAD'
                }).fail(function () {
                    $('<span class="alert alert-error"/>')
                    .text('Upload server currently unavailable - ' +
                        new Date())
                    .appendTo('#fileupload');
                });
            }
        } else {
            // Load existing files:
            $('#fileupload').each(function () {
                var that = this;
            
            
                uploadLoadAction({url : "<?php echo $this->url(array('Uploads::loadAction', 'type' => 'json')); ?>"}, function (data) {
                    var result = data.files;           
                    if (result && result.length) {
                        $(that).fileupload('option', 'done')
                        .call(that, null, {
                            result: result
                        });
                    }
                
                });
        
            
                /* 
            $.getJSON(this.action, function (result) {
                if (result && result.length) {
                    $(that).fileupload('option', 'done')
                    .call(that, null, {
                        result: result
                    });
                }
            });
                 */
            
            });
        
        

        
        }
    
    
        $(".delete_button").live('click', function(e){
            e.preventDefault();
            var element = $(this).parents('tr');
            uploadDeleteAction({url: "<?php echo $this->url(array('Uploads::deleteAction', 'type' => 'json')); ?>", id: $(element).data('id')}, function(data) {
                displaySuccessNotice(data.details, null);
                $(element).removeClass('fade').fadeOut("slow", function () {
                    $(this).remove();
                });    
                return false;
            });
            return false;      
        });
    
    });
</script>