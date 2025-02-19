document.addEventListener("DOMContentLoaded", function () {
    const ogImgBtn = document.querySelector("#og-img-btn");
    const ogImgCtr = document.querySelector(".media-preview");
    const ogImgInput = document.querySelector("#up_og_image");


    const mediaFrame = wp.media({
        title: "Pasirinkite failą",
        button: {
            text: "Naudoti šį failą",
        },
        multiple: 'add',
        library: {
            type: 'image', // Leidžia matyti tik vaizdus (keiskite pagal poreikį)
            author: wp_media_settings.user_id // Filtruojame pagal vartotojo ID
        }
    });

    ogImgBtn.addEventListener("click", (event) => {
        event.preventDefault();
        mediaFrame.open();
    });

    mediaFrame.on("select", () => {
        const selectedImages = mediaFrame.state().get("selection").toJSON(); 
        ogImgCtr.innerHTML = ''; 
        const imageUrls = []; 
        selectedImages.forEach((attachment, index) => {
          const imageUrl = attachment.sizes.medium ? attachment.sizes.medium.url : attachment.url; 
          console.log(imageUrl);
      
          const imgElement = document.createElement('img');
          imgElement.src = imageUrl;
          imgElement.alt = attachment.alt || 'No Alt Text'; 
          imgElement.style.margin = '5px';
          imgElement.style.width = '100px';
          imgElement.style.height = 'auto'; 
      
          ogImgCtr.appendChild(imgElement);
          imageUrls.push(imageUrl);
          console.log(imageUrls);
        });
        ogImgInput.value = imageUrls.join(','); 
      });
      
});
