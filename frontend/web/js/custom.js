/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).on('ready pjax:success', function() {
    $('.modal-btn').on('click', function() {
        $('#modal').modal('show')
            .find('#modal-content')            
            .load($(this).attr('data-target'));    
        $('#modal .modal-header').html('<h3>'+$(this).attr('data-title')+'</h3>');
    });
});
