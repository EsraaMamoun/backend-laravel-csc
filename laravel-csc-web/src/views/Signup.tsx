import { createRef, useState, FormEvent } from "react";
import { Link } from "react-router-dom";
import axiosClient from "../axios-client";
import { useStateContext } from "../context/ContextProvider";

interface Errors {
  [key: string]: string[];
}

export default function Signup() {
  const usernameRef = createRef<HTMLInputElement>();
  const emailRef = createRef<HTMLInputElement>();
  const passwordRef = createRef<HTMLInputElement>();
  const passwordConfirmationRef = createRef<HTMLInputElement>();
  // const { setUser, setToken } = useStateContext();
  const [errors, setErrors] = useState<Errors | null>(null);
  const { setNotification } = useStateContext();

  const onSubmit = (ev: FormEvent) => {
    ev.preventDefault();

    const payload = {
      username: usernameRef.current?.value,
      email: emailRef.current?.value,
      password: passwordRef.current?.value,
      password_confirmation: passwordConfirmationRef.current?.value,
    };

    axiosClient
      .post("/signup", payload)
      .then(({ data }) => {
        console.log(data);

        setNotification(
          "Congratulations! Please wait for the administrator to activate your account."
        );
      })
      .catch((err) => {
        console.log("error.", err);

        const response = err.response;
        if (response && response.status === 422) {
          setErrors(response.data.errors);
        }
      });
  };

  return (
    <div className="login-signup-form animated fadeInDown">
      <div className="form">
        <form onSubmit={onSubmit}>
          <h1 className="title">Signup</h1>
          {errors && (
            <div className="alert">
              {Object.keys(errors).map((key) => (
                <p key={key}>{errors[key][0]}</p>
              ))}
            </div>
          )}
          <input ref={usernameRef} type="text" placeholder="Username" />
          <input ref={emailRef} type="email" placeholder="Email Address" />
          <input ref={passwordRef} type="password" placeholder="Password" />
          <input
            ref={passwordConfirmationRef}
            type="password"
            placeholder="Repeat Password"
          />
          <button className="btn btn-block">Signup</button>
          <p className="message">
            Already registered? <Link to="/login">Sign In</Link>
          </p>
        </form>
      </div>
    </div>
  );
}
