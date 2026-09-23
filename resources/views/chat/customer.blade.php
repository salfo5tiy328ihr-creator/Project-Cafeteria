@extends('layouts.customer')

@section('title', 'AI Chat')

@section('content')
<div style="margin-bottom: 25px;">
    <h2 style="font-weight: 700; color: #1f2937; display: flex; align-items: center; gap: 10px;">
        <i class="fas fa-robot" style="color: #6366f1;"></i> AI Chat
    </h2>
    <p style="color: #6b7280; margin-top: 5px;">Ask me anything about our menu and get instant recommendations!</p>
</div>

<div class="card" style="max-width: 900px;">
    <div class="card-body" style="padding: 0;">
        <div id="chatBox" style="height: 500px; overflow-y: auto; padding: 25px; background: #f9fafb;">
            <div class="chat-message bot" style="display: flex; gap: 12px; margin-bottom: 20px;">
                <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #6366f1, #a855f7); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; flex-shrink: 0;">
                    <i class="fas fa-robot"></i>
                </div>
                <div style="background: white; padding: 12px 18px; border-radius: 15px 15px 15px 5px; max-width: 70%; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                    Hello {{ auth()->user()->name }}! 👋 I'm your AI assistant. Try asking me:<br>
                    • "Recommend something spicy"<br>
                    • "What's under 100 EGP?"<br>
                    • "Suggest a cold drink"<br>
                    • "Healthy meal"<br>
                    • "Compare two meals"
                </div>
            </div>
        </div>
        
        <div style="padding: 20px; border-top: 1px solid #e5e7eb; display: flex; gap: 10px; background: white;">
            <input type="text" id="messageInput" placeholder="Type your message..." style="flex: 1; padding: 14px 18px; border: 2px solid #e5e7eb; border-radius: 12px; font-family: 'Cairo'; outline: none;" onkeypress="if(event.key==='Enter') sendMessage()">
            <button onclick="sendMessage()" class="btn-submit" style="width: auto; padding: 14px 25px; margin: 0;">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>

<script>
const chatBox = document.getElementById('chatBox');
const input = document.getElementById('messageInput');

function sendMessage() {
    const msg = input.value.trim();
    if (!msg) return;
    
    addMessage(msg, 'user');
    input.value = '';
    
    fetch('{{ route("chat.send") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ message: msg })
    })
    .then(r => r.json())
    .then(data => addMessage(data.reply, 'bot'))
    .catch(() => addMessage('Sorry, something went wrong.', 'bot'));
}

function addMessage(text, type) {
    const div = document.createElement('div');
    div.style.cssText = 'display: flex; gap: 12px; margin-bottom: 20px;' + (type === 'user' ? ' flex-direction: row-reverse;' : '');
    
    const icon = type === 'user' 
        ? '<div style="width: 40px; height: 40px; background: #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; flex-shrink: 0;"><i class="fas fa-user"></i></div>'
        : '<div style="width: 40px; height: 40px; background: linear-gradient(135deg, #6366f1, #a855f7); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; flex-shrink: 0;"><i class="fas fa-robot"></i></div>';
    
    const bubbleStyle = type === 'user' 
        ? 'background: #6366f1; color: white; padding: 12px 18px; border-radius: 15px 15px 5px 15px; max-width: 70%;'
        : 'background: white; padding: 12px 18px; border-radius: 15px 15px 15px 5px; max-width: 70%; box-shadow: 0 2px 5px rgba(0,0,0,0.05);';
    
    div.innerHTML = icon + '<div style="' + bubbleStyle + ' white-space: pre-line;">' + text + '</div>';
    chatBox.appendChild(div);
    chatBox.scrollTop = chatBox.scrollHeight;
}
</script>
@endsection