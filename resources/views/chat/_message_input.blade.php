<div class="chat-input-area">
    <form id="messageForm" class="chat-input-form">
        @csrf
        <i class="fas fa-smile emoji-btn"></i>
        <i class="fas fa-paperclip attach-btn"></i>
        <input type="text" id="message" name="message" placeholder="Type a message..." autocomplete="off">
        <button type="submit" class="send-btn">
            <i class="fas fa-paper-plane"></i>
        </button>
    </form>
</div>
