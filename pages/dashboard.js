import { useEffect } from "react";
import { useRouter } from "next/router";
import CopyableUrl from "../components/CopyableUrl";
import WhatsAppIcon from "../components/WhatsAppIcon";
import { urls, whatsappLink } from "../config";

export default function Dashboard() {
  const router = useRouter();

  // Simple auth guard: redirect to login if no query param ?auth=true
  // (Karena ini contoh sederhana, Anda bisa ganti dengan sistem auth lebih baik)
  useEffect(() => {
    // Jika ingin pakai query param auth, uncomment ini:
    // if (router.query.auth !== "true") {
    //   router.push("/");
    // }
  }, [router]);

  return (
    <div
      style={{
        minHeight: "100vh",
        background:
          "radial-gradient(circle at top left, #667eea, #764ba2)",
        fontFamily: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif",
        color: "white",
        padding: 40,
        display: "flex",
        flexDirection: "column",
        alignItems: "center",
      }}
    >
      <h1
        style={{
          fontSize: 36,
          marginBottom: 40,
          animation: "fadeInDown 1s ease forwards",
          opacity: 0,
        }}
        className="fadeInDown"
      >
        Dashboard
      </h1>

      <div
        style={{
          display: "grid",
          gridTemplateColumns: "repeat(auto-fit, minmax(220px, 1fr))",
          gap: 20,
          width: "100%",
          maxWidth: 1200,
          animation: "fadeInUp 1s ease forwards",
          opacity: 0,
          animationDelay: "0.5s",
        }}
        className="fadeInUp"
      >
        {urls.map((url, i) => (
          <CopyableUrl key={i} url={url} />
        ))}
      </div>

      <WhatsAppIcon href={whatsappLink} />
      <style jsx global>{`
        @keyframes fadeInDown {
          0% {
            opacity: 0;
            transform: translateY(-20px);
          }
          100% {
            opacity: 1;
            transform: translateY(0);
          }
        }
        @keyframes fadeInUp {
          0% {
            opacity: 0;
            transform: translateY(20px);
          }
          100% {
            opacity: 1;
            transform: translateY(0);
          }
        }
        .fadeInDown {
          animation-name: fadeInDown;
          animation-fill-mode: forwards;
        }
        .fadeInUp {
          animation-name: fadeInUp;
          animation-fill-mode: forwards;
          animation-delay: 0.5s;
        }
      `}</style>
    </div>
  );
}
