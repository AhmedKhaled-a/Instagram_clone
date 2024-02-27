<nav class="main-menu">
            <ul>
                <li>
                    <a href="{{route("home")}}">
                        <i class="fa fa-home fa-2x"></i>
                        <span class="nav-text">
                           Home
                        </span>
                    </a>
                </li>
                <li class="has-subnav">
                    <a href="{{route("posts.create")}}">
                        <i class="fa fa-paper-plane fa-2x"></i>
                        <span class="nav-text">
                            What's on your mind
                        </span>
                    </a>
                    
                </li>
                <li class="has-subnav">
                    <a href="href="{{route("saved-posts.show")}}"">
                       <i class="fa fa-floppy-disk fa-2x"></i>
                        <span class="nav-text">
                            Saved Posts
                        </span>
                    </a>
                    
                </li>
                <li class="has-subnav">
                    <a href="#">
                       <i class="fa fa-user fa-2x"></i>
                        <span class="nav-text">
                            Survey Profile
                        </span>
                    </a>
                   
                </li>
                <li>
                    <a href="{{route("posts.index")}}">
                        <i class="fa fa-film fa-2x"></i>
                        <span class="nav-text">
                            Explore
                        </span>
                    </a>
                </li>
            <ul class="logout">
                <li>
                   <a href="{{route("logout")}}">
                         <i class="fa fa-power-off fa-2x"></i>
                        <span class="nav-text">
                            Logout
                        </span>
                    </a>
                </li>  
            </ul>
        </nav>