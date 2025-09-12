<x-app-layout>

    <div class="max-w-3xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-4">Chat AI Brikta Sumba</h1>

        <div id="chat-box" class="border rounded p-4 h-96 overflow-y-auto mb-4 bg-gray-50"></div>

        <form id="chat-form">
            <input type="text" name="message" id="message" placeholder="Tanya berita..."
                class="w-full border rounded px-3 py-2 mb-2" required>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Kirim</button>
        </form>
    </div>

    <script>
        document.getElementById('chat-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const messageInput = document.getElementById('message');
            const message = messageInput.value;
            const chatBox = document.getElementById('chat-box');

            chatBox.innerHTML += `<div class="text-right text-blue-600 mb-2">${message}</div>`;
            messageInput.value = '';

            const res = await fetch('{{ route('chat.send') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    message
                })
            });
            const data = await res.json();

            chatBox.innerHTML += `<div class="text-left text-gray-800 mb-2">${data.reply}</div>`;
            chatBox.scrollTop = chatBox.scrollHeight;
        });
    </script>

</x-app-layout>
