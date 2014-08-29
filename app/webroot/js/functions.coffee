(($) ->
    $ ->
        # Add room to hotels.admin_edit 
        $('#addTr').on 'click', (e)->
            e.preventDefault()
            template = $.templates("#trRoom")
            fila = $ template.render() 
            # delete row Room  
            $('a.deleteTrRoom', fila ).on  'click', ( e ) -> 
                e.preventDefault()
                console.log( @ ) 
                $(@).parent().parent().remove()
                return
            $('#tablaTarifas tbody').append   fila  
            return
        # delete row Room  
        $('a.deleteTrRoom').on  'click', ( e ) -> 
            e.preventDefault()
            console.log( @ ) 
            $(@).parent().parent().remove()
            return
        return
    return 
) jQuery