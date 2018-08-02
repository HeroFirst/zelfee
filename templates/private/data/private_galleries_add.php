<script>
    var images = [];

    function getFileUploadBlock(index, name, val){
        return '<div class="col-md-3"><div class="image-add-box margin-bottom '+((val=='') ? 'image-add-box-empty': '')+'" id="image-add-box'+index+'">' +
            '<div class="square">' +
            '<div class="square-content">' +
            '<div class="overlay"></div> ' +
            '<div class="content" '+((val!='') ? 'style="background-image:url(' + val + ')"' : '')+'> ' +
            '<a class="image-add-box-add" href="#"> ' +
            '<span>Добавить<br />изображение</span> ' +
            '</a>' +
            '<a class="image-add-box-close" data-index="'+index+'" href="#">x' +
            '<i class="fa fa-times"></i>' +
            '</a> ' +
            '<input type="hidden" value="'+val+'" name="'+name+'" required />' +
            '</div>' +-
            '</div> ' +
            '</div>' +
            '</div>' +
            '</div>';
    }

    function openElFinderWithCallback(callback) {
        var fm = $('<div/>').dialogelfinder({
            url : '/Libraries/elfinder/connector.minimal.php',
            lang : 'en',
            width : 840,
            height: 450,
            destroyOnClose : true,
            getFileCallback : callback,
            commandsOptions : {
                getfile : {
                    oncomplete : 'close',
                    folders : false
                }
            }
        }).dialogelfinder('instance');
    }

    function updateImagesContainer() {
        console.log(images);

        imagesContainer = $('.images-container');
        imagesCount = images.length;

        imagesContainer.html('');
        for (i = 0; i<imagesCount; i++){
            imagesContainer.append(getFileUploadBlock(i, 'images[]', images[i]));
        }
        imagesContainer.append(getFileUploadBlock(imagesCount, 'images[]', ''));

        $('.image-add-box').each(function (index) {
            var imageBox = $(this);
            var id = imageBox.attr('id');

            var content = $(this).find('.content');
            var buttonAdd = $(this).find('.image-add-box-add');
            var buttonRemove = $(this).find('.image-add-box-close');
            var inputText = $(this).find('input[type=hidden]');

            var classEmpty = 'image-add-box-empty';

            buttonAdd.click(function (e) {
                openElFinderWithCallback(
                    function(files, fm) {
                        imageBox.removeClass(classEmpty);
                        content.css('background-image', 'url('+fm.convAbsUrl(files.url)+')');
                        inputText.val(fm.convAbsUrl(files.url));
                        images.push(files.url);

                        updateImagesContainer();}
                );

                e.preventDefault();
            });

            buttonRemove.click(function (e) {
                imageBox.addClass(classEmpty);
                content.css('background-image', 'none');
                inputText.val('');

                var removeIndex = $(this).data('index');
                console.log('index = '+removeIndex);

                images.splice(removeIndex, 1);
                updateImagesContainer();

                e.preventDefault();
            });
        });
    }

    $(document).ready(function(){
        updateImagesContainer();
    });
</script>