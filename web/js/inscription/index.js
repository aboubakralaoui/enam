$(window).load(function() {    
    $(document).on('click touchstart', '#forward , #span-forward , #backward , #span-backward', function () {
        // alert(1);
        gender = $("input:radio[name=gender]:checked").val();
        $.ajax({
            url: "../cnc/insertIdentite", 
            type: "POST",             
            data: 
                {
                    firstname   :   $('#firstname').val() , 
                    lastname    :   $('#lastname').val(),
                    email       :   $('#email').val() , 
                    cin         :   $('#cin').val(),
                    cne         :   $('#cne').val() , 
                    phone       :   $('#phone').val(),
                    adresse     :   $('#adresse').val() , 
                    datenaiss   :   $('#date-naissance').val(), 
                    lieunaiss   :   $('#lieu-naissance').val(), 
                    gender      :   gender, 
                    country     :   $('#country').val(),
                    centre_casa :   $('#centre_casa').val(), 
                }, 
            success: function(data){
                
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
                console.log("error");
            }
        });


        $.ajax({
            url: "../cnc/insertFomationBac", 
            type: "POST", 
            dataType: 'json',            
            data: 
                {
                    formationbac   :   $('#formation-bac').val() , 
                    annee          :   $('#formation-bac-1-annee').val(),
                    type           :   $('#formation-bac-1-type').val() , 
                    serie          :   $('#formation-bac-1-serie').val(),
                    moyenne        :   $('#formation-bac-1-moyenne').val()
                }, 
            success: function(data){
                $('#formation-bac').val(data.id)
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
                console.log("error");
            }
        });



        $.ajax({
            url: "../cnc/insertFomationCGPE", 
            type: "POST", 
            dataType: 'json',            
            data: 
                {
                    formationcgpe   :   $('#formation-cgpe').val() , 
                    filiere          :   $('#formation-cgpe-1-filiere').val(),
                    classe           :   $('#formation-cgpe-1-classe').val() , 
                    centre          :   $('#formation-cgpe-1-centre').val(),
                    situation        :   $('#formation-cgpe-1-situation').val()
                }, 
            success: function(data){
                $('#formation-cgpe').val(data.id);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
                console.log("error");
            }
        });



        $.ajax({
            url: "../cnc/insertFomationCGPE1", 
            type: "POST", 
            dataType: 'json',            
            data: 
                {
                    formationcgpe  :   $('#formation_formation_cpg1').val() , 
                    annee          :   $('#formation_formation_cpg1_annee').val(),
                    centre         :   $('#formation_formation_cpg1_centre').val() , 
                    type_filiere   :   $('#formation_formation_cpg1_type_filiere').val(),
                    classe         :   $('#formation_formation_cpg1_classe').val()
                }, 
            success: function(data){
                $('#formation_formation_cpg1').val(data.id);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
                console.log("error");
            }
        });


        $.ajax({
            url: "../cnc/insertFomationCGPE2", 
            type: "POST",
            dataType: 'json',             
            data: 
                {
                    formationcgpe   :   $('#formation_formation_cpg2').val() , 
                    annee          :   $('#formation_formation_cpg2_annee').val(),
                    centre           :   $('#formation_formation_cpg2_centre').val() , 
                    type_filiere          :   $('#formation_formation_cpg2_type_filiere').val(),
                    classe        :   $('#formation_formation_cpg2_classe').val()
                }, 
            success: function(data){
                $('#formation_formation_cpg2').val(data.id);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
                console.log("error");
            }
        });



        $.ajax({
            url: "../cnc/insertFomationAutre1", 
            type: "POST", 
            dataType: 'json',            
            data: 
                {
                    formationautre   :   $('#formation_autre1').val() , 
                    annee          :   $('#autre1_annee').val(),
                    centre           :   $('#autre1_centre').val() , 
                    type_filiere          :   $('#autre1_type_filiere').val(),
                    classe        :   $('#autre1_classe').val()
                }, 
            success: function(data){
                $('#formation_autre1').val(data.id);
                
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
                console.log("error");
            }
        });



        $.ajax({
            url: "../cnc/insertFomationAutre2", 
            type: "POST", 
            dataType: 'json',            
            data: 
                {
                    formationautre   :   $('#formation_autre2').val() , 
                    annee          :   $('#autre2_annee').val(),
                    centre           :   $('#autre2_centre').val() , 
                    type_filiere          :   $('#autre2_type_filiere').val(),
                    classe        :   $('#autre2_classe').val()
                }, 
            success: function(data){
                $('#formation_autre2').val(data.id);
                
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
                console.log("error");
            }
        });


    


        $.ajax({
            url: "../cnc/insertParticipation1", 
            type: "POST", 
            dataType: 'json',            
            data: 
                {
                    participation   : $('#participations_1').val() , 
                    type   :   $('#participation1_type').val() , 
                    annee  :   $('#participation1_annee').val()
                }, 
            success: function(data){
                $('#participations_1').val(data.id);
                
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
                console.log("error");
            }
        });


        $.ajax({
            url: "../cnc/insertParticipation2", 
            type: "POST",  
            dataType: 'json',           
            data: 
                {
                    participation   : $('#participations_2').val() ,  
                    type            :   $('#participation2_type').val() , 
                    annee           :   $('#participation2_annee').val()
                }, 
            success: function(data){
                $('#participations_2').val(data.id);
                
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
                console.log("error");
            }
        });




        $.ajax({
            url: "../cnc/insertSujet", 
            type: "POST",
            dataType: 'json',             
            data: 
                {
                    sujet_id             : $('#sujet_id').val() ,  
                    intitule_sujet      :   $('#intitule_sujet').val() , 
                    dominante           :   $('#dominante').val(),
                    resume           :   $('#resume').val(),
                }, 
            success: function(data){
                $('#sujet_id').val(data.id);
                
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
                console.log("error");
            }
        });



        $.ajax({
            url: "../cnc/recap", 
            type: "POST",             
            data: 
                {
                
                }, 
            success: function(data){
                $('#end').html(data);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
                console.log("error");
            }
        });


    });
});
