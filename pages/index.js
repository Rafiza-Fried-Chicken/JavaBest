import { useState } from "react";
import { useRouter } from "next/router";
import { credentials } from "../config";

export default function Login() {
  const router = useRouter();
  const [user, setUser ] = useState("");
  const [pw, setPw] = useState("");
  const [error, setError] = useState("");

  const handleLogin = (e) => {
    e.preventDefault();
    if (user === credentials.username && pw === credentials.password) {
      router.push("/dashboard");
    } else {
      setError("Username atau password salah");
    }
  };

  return (
    <div
      style={{
        height: "100vh",
        display: "flex",
        justifyContent: "center",
        alignItems: "center",
        background:
          "linear-gradient(135deg, #667eea 0%, #764ba2 100%)",
        fontFamily: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif",
      }}
    >
      <form
        onSubmit={handleLogin}
        style={{
          backgroundColor: "white",
          padding: 40,
          borderRadius: 12,
          boxShadow: "0 10px 30px rgba(0,0,0,0.1)",
          width: 320,
          textAlign: "center",
        }}
      >
        <h2 style={{ marginBottom: 24, color: "#333" }}>Login</h2>
        <input
          type="text"
          placeholder="Username"
          value={user}
          onChange={(e) => setUser (e.target.value)}
          required
          style={{
            width: "100%",
            padding: 12,
            marginBottom: 16,
            borderRadius: 6,
            border: "1px solid #ccc",
            fontSize: 16,
          }}
        />
        <input
          type="password"
          placeholder="Password"
          value={pw}
          onChange={(e) => setPw(e.target.value)}
          required
          style={{
            width: "100%",
            padding: 12,
            marginBottom: 16,
            borderRadius: 6,
            border: "1px solid #ccc",
            fontSize: 16,
          }}
        />
        <button
          type="submit"
          style={{
            width: "100%",
            padding: 12,
            backgroundColor: "#667eea",
            border: "none",
            borderRadius: 6,
            color: "white",
            fontSize: 16,
            cursor: "pointer",
            transition: "background-color 0.3s",
          }}
          onMouseEnter={(e) => (e.target.style.backgroundColor = "#5a67d8")}
          onMouseLeave={(e) => (e.target.style.backgroundColor = "#667eea")}
        >
          Login
        </button>
        {error && (
          <p style={{ color: "red", marginTop: 12, fontSize: 14 }}>
            {error}
          </p>
        )}
      </form>
    </div>
  );
}
