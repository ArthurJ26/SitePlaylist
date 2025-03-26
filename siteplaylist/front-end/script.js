
async function saveVideo() {
    const urlInput = document.getElementById("youtube-url").value;
    const videoId = extractVideoId(urlInput);

    if (videoId) {
        const thumbnailUrl = `https://img.youtube.com/vi/${videoId}/maxresdefault.jpg`;
        const videoUrl = `https://www.youtube.com/watch?v=${videoId}`;

        try {
            const response = await fetch("../back-end/api.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    video_url: videoUrl,
                    thumbnail_url: thumbnailUrl
                })
            });

            if (!response.ok) {
                console.error("Erro na resposta do servidor:", response.status);
                alert("Erro ao salvar o vídeo. Status: " + response.status);
                return;
            }

            const result = await response.json();

            if (result.message) {
                alert(result.message); 
                window.location.reload(); 
            } else if (result.error) {
                alert("Erro: " + result.error); 
            }
        } catch (error) {
            console.error("Erro na requisição:", error);
            alert("Ocorreu um erro ao salvar o vídeo. Tente novamente.");
        }

        document.getElementById("youtube-url").value = "";
    } else {
        alert("URL inválida. Por favor, insira uma URL válida de um vídeo do YouTube.");
    }
}

function extractVideoId(url) {
    const regex = /(?:https?:\/\/(?:www\.)?youtube\.com\/(?:[^\/]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=|.*[\/&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/;
    const match = url.match(regex);
    return match ? match[1] : null;
}

window.addEventListener("scroll", function(){
    let header = document.querySelector('#header')
    header.classList.toggle('rolagem', window.scrollY > 80)
})

