import { useState } from "react";

export default function CopyableUrl({ url }) {
  const [copied, setCopied] = useState(false);

  const copyToClipboard = () => {
    navigator.clipboard.writeText(url);
    setCopied(true);
    setTimeout(() => setCopied(false), 2000);
  };

  return (
    <div
      onClick={copyToClipboard}
      style={{
        cursor: "pointer",
        padding: "10px",
        borderRadius: "8px",
        backgroundColor: copied ? "#4caf50" : "#f0f0f0",
        color: copied ? "white" : "black",
        userSelect: "none",
        textAlign: "center",
        boxShadow: "0 2px 5px rgba(0,0,0,0.1)",
        transition: "background-color 0.3s",
      }}
      title="Klik untuk menyalin URL"
    >
      {copied ? "Disalin!" : url}
    </div>
  );
}
