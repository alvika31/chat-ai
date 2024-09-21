import React, { useEffect, useState } from "react";
import axios from "axios";

export default function Index({ conversation }) {
    const [messages, setMessages] = useState(conversation?.messages);
    const [input, setInput] = useState("");

    useEffect(() => {
        // Simpan session_id di localStorage
        if (conversation?.session_custom_id != null) {
            localStorage.setItem(
                "session_id",
                conversation?.session_custom_id ?? ""
            );
        }
    }, []);

    async function query(data) {
        const response = await fetch(
            "https://api-inference.huggingface.co/models/gpt2",
            {
                method: "POST",
                headers: {
                    Authorization: `Bearer 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`,
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(data),
            }
        );
        const result = await response.json();
        return result;
    }

    const sendMessage = async () => {
        // // Kirim pesan ke server
        const response = await axios.post("/chat", { message: input });
        console.log(response.data);
        setMessages(response.data.messages);
        setInput("");
    };
    return (
        <div className="h-screen flex flex-col justify-center items-center">
            <div className="flex flex-col gap-y-3">
                {messages &&
                    messages?.map((item) => (
                        <div key={item.id}>{item.content}</div>
                    ))}
            </div>
            <h1>Welcome</h1>
            <input value={input} onChange={(e) => setInput(e.target.value)} />
            <button onClick={sendMessage}>Send</button>
        </div>
    );
}
