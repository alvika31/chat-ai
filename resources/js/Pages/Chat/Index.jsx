import React, {useEffect, useState} from "react";
import axios from "axios";

export default function Index({conversation}){
    console.log(conversation)
    const [messages, setMessages] = useState('');
    const [input, setInput] = useState('');

    useEffect(() => {
        // Simpan session_id di localStorage
        localStorage.setItem('session_id', conversation?.session_custom_id);
    }, [conversation.session_custom_id]);


    const sendMessage = async () => {
        // Kirim pesan ke server
        const response = await axios.post('/chat', { message: input });
        setMessages(response.data.conversation.messages);
        setInput('');
    };
    return (
        <div className="h-screen flex flex-col justify-center items-center">
           <h1>Welcome</h1>
           <input
                value={input}
                onChange={(e) => setInput(e.target.value)}
                
            />
            <button onClick={sendMessage}>Send</button>
        </div>
    )
}