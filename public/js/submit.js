(function(){
    
    $('.form-prevent-multiple-submit').on('submit', function(){
        $('.button-prevent-multiple-submit').attr('disabled', 'true');
        $('.spinner').show();
    })
})();