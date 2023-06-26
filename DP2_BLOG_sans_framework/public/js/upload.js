    const input = document.querySelector('#image_uploads');
    const preview = document.querySelector('.preview');
    const newmedias = document.querySelector('#newmedias');
    
  if( input != null ) 
  {           
    input.style.opacity = 0;

    input.addEventListener('change', updateImageDisplay);

    function updateImageDisplay() {
      while(preview.firstChild) {
        preview.removeChild(preview.firstChild);
      }
      while(newmedias.firstChild) {
        newmedias.removeChild(newmedias.firstChild);
      }

      const curFiles = input.files;
      console.log(input.files);
      const directory = input.files.URL;
      if(curFiles.length === 0) {
        const para = document.createElement('p');
        para.textContent = 'No files currently selected for upload';
        preview.appendChild(para);
      } else {
        const list = document.createElement('ol');
        preview.appendChild(list);       

        for(const file of curFiles) {
          const listItem = document.createElement('li');   
          const para = document.createElement('p');
          const paraOption = document.createElement('p');
          const listOption = document.createElement('option');

          if(validFileType(file)) {
            para.textContent = `${file.name}, file size ${returnFileSize(file.size)}.`;
            
            const image = document.createElement('img');
            image.src = URL.createObjectURL(file);
            listOption.value = `images/`+`${file.name}`;
            listOption.textContent = `images/`+`${file.name}`;
            console.log(file);
            listOption.selected = true;
            
            listItem.appendChild(image);
            listItem.appendChild(para);
           // listOption.appendChild(paraOption);
          } else {
            para.textContent = `File name ${file.name}: Not a valid file type. Update your selection.`;
            listItem.appendChild(para);
          }

          list.appendChild(listItem);
          newmedias.appendChild(listOption);
        }
      }
    }
  }

// https://developer.mozilla.org/en-US/docs/Web/Media/Formats/Image_types
    const fileTypes = [
        'image/apng',
        'image/bmp',
        'image/gif',
        'image/jpeg',
        'image/pjpeg',
        'image/png',
        'image/svg+xml',
        'image/tiff',
        'image/webp',
        `image/x-icon`
    ];

    function validFileType(file) {
      return fileTypes.includes(file.type);
    }

    function returnFileSize(number) {
      if(number < 1024) {
        return number + 'bytes';
      } else if(number > 1024 && number < 1048576) {
        return (number/1024).toFixed(1) + 'KB';
      } else if(number > 1048576) {
        return (number/1048576).toFixed(1) + 'MB';
      }

    }