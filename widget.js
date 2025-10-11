(function() 
{
    // === Customizable Config ===
    window.chatWidgetConfig = 
    {
        headerColor:'#0078d7',
        buttonColor:'#ff4081',
        agentName:'Team Support',
        agentAvatar:'https://yourdomain.com/path/to/avatar.png',
        agentResponseTime:'Typically replies within 10 minutes',
        chatHtmlUrl:(window.chatboxbaseurl || '') + '/chatbox/widget.html'
    };

    const config = window.chatWidgetConfig;
    const chatUrl = config.chatHtmlUrl;

    const faLink = document.createElement('link');
    faLink.rel = 'stylesheet';
    faLink.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css';
    document.head.appendChild(faLink);

    // === Create Chat Iframe ===
    const iframe = document.createElement('iframe');
    iframe.src = chatUrl;
    iframe.style.position = 'fixed';
    iframe.style.bottom = '90px';
    iframe.style.right = '20px';
    iframe.style.width = '360px';
    iframe.style.height = '500px';
    iframe.style.border = 'none';
    iframe.style.zIndex = '9999';
    iframe.style.borderRadius = '12px';
    iframe.style.boxShadow = '0 4px 12px rgba(0,0,0,0.3)';
    iframe.style.display = 'none';

    // === Create Toggle Button ===
    const button = document.createElement('button');
    button.id = 'chatToggle';
    button.innerHTML = '<i class="fa-solid fa-message"></i>';
    button.style.position = 'fixed';
    button.style.bottom = '20px';
    button.style.right = '20px';
    button.style.width = '50px';
    button.style.height = '50px';
    button.style.borderRadius = '50%';
    button.style.border = 'none';
    button.style.backgroundColor = config.buttonColor || config.headerColor || '#0078d7';
    button.style.color = '#fff';
    button.style.fontSize = '18px';
    button.style.cursor = 'pointer';
    button.style.boxShadow = '0 4px 8px rgba(0,0,0,0.3)';
    button.style.zIndex = '9999';

    let isChatOpen = false;

    button.addEventListener('click', () => 
    {
        iframe.style.display = 'block';
        button.style.display = 'none';
        isChatOpen = true;
    });

    // Allow widget to control toggle visibility and color
    window.chatToggleButton = button;

    // === Allow iframe to control button color ===
    window.addEventListener("message", function(event) 
    {
        if (event.data && event.data.type === "setButtonColor") 
        {
            const newColor = event.data.color;
            if (window.chatToggleButton) 
            {
                window.chatToggleButton.style.backgroundColor = newColor;
            }
        }
    });

    // === Append Elements on Load ===
    window.addEventListener('load', () =>
    {
        document.body.appendChild(faLink);
        document.body.appendChild(button);
        document.body.appendChild(iframe);
    });
})();
