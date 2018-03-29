function processUpload() {
		
    alert("In Process Mode");   
    
    /*
			prepareing ajax file upload
			url: the url of script file handling the uploaded files
                        fileElementId: the file type of input element id and it will be the index of  $_FILES Array()
			dataType: it support json, xml
			secureuri:use secure protocol
			success: call back function when the ajax complete
			error: callback function when the ajax failed
			
                */
		$.ajaxFileUpload
		(
			{
				url:'upload.php', 
				secureuri:false,
				fileElementId:'FileUpload',
				dataType: 'json',
        		beforeSend:function()
				{
					alert("Before send");
				},
				complete:function()
				{
                    
                    alert("After send");
                    
				},			
        success: function (data, status)
				{
					if(typeof(data.error) != 'undefined')
					{
						if(data.error != '')
						{
							alert(data.error);
						}else
						{
							alert(data.msg);
						}
					}
					else {
            alert("Some other issue: "+data.msg+ " "+data.error + " "+status);
          }
				},
				error: function (data, status, e)
				{
					alert(e);
				}
			}
		)
		
		return false;

} //processUpload