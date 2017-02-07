<li><!-- start message -->
    <a href="#">
        <h4>
            {{ $message->name }}
            <small><i class="fa fa-clock-o"></i> {{ $message->created_at->diffForHumans() }}</small>
        </h4>
        <p>{{ str_limit($message->message,40) }}</p>
    </a>
</li>